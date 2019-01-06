/**
 * Add an "CMS internal link" option to the Link plugin.
 *
 *    Written by Majid Alavizadeh <majidonline@gmail.com>
 *
 */

(function ($) {
    var getById = function (array, id, recurse) {
        for (var i = 0, item; (item = array[i]); i++) {
            if (item.id == id) return item;
            if (recurse && item[recurse]) {
                var retval = getById(item[recurse], id, recurse);
                if (retval) return retval;
            }
        }
        return null;
    };

    var resetInitValues = function (dialog) {
        dialog.foreach(function (contentObj) {
            contentObj.setInitValue && contentObj.setInitValue();
        });
    };

    CKEDITOR.plugins.add('content', {

        init: function (editor, pluginPath) {
            // Hook us into the creation process of the link dialog
            CKEDITOR.on('dialogDefinition', function (e) {
                if ((e.editor != editor) || (e.data.name != 'link'))
                    return;

                postID = 0;
                var definition = e.data.definition;

                // When OK is pressed in the dialog. In some cases we need to
                // post-process the link we are inserting.
                definition.onOk = CKEDITOR.tools.override(definition.onOk, function (original) {
                    return function () {
                        var isNewLinkWithText = false;
                        // Test if there is no selection in the editor (that is, just
                        // a simple blinking cursor - a "collapsed" range), and we are
                        // not editing an existing link below the cursor (selectedElement),
                        // but are inserting a new one.
                        if ((this.getValueOf('info', 'linkType') == 'content') && !this._.selectedElement) {
                            var ranges = editor.getSelection().getRanges(true);
                            if ((ranges.length == 1) && ranges[0].collapsed) {
                                // This means CKEditor will not just add a href to an
                                // existing piece of text, but will also insert the link
                                // text itself, which will be the url.
                                isNewLinkWithText = true;
                            }
                        }

                        // Let the original link dialog insert the link into the text.
                        // We can't really customize this code, so we need to make our
                        // changes afterwards
                        original.call(this);

                        // If CKEditor must created a new link with "content://1234" as
                        // the text, which is tremendously unuseful, then we will
                        // replace that text with the title of the page linked to.
                        if (isNewLinkWithText) {
                            var value = getPageSpan(dialog).getAttribute('pageTitle');
                            if (value) {
                                CKEDITOR.plugins.link.getSelectedLink(editor).setText(value);
                            }
                        }
                    };
                });

                var infoTab = definition.getContents('info');

                var linkTypeSelect = getById(infoTab.elements, 'linkType');
                linkTypeSelect.items.unshift(['صفحات سایت', 'content']);


                var getPageSpan = function (dialog) {
                    var pageIdDisplay = dialog.getContentElement('info', 'contentPage');
                    return pageIdDisplay.getElement().$;
                };

                var setTargetPage = function (dialog, page, version) {
                    var span = getPageSpan(dialog);
                    if (page) {
                        span.setAttribute('pageId', page.getId());
                        if (version)
                            span.setAttribute('versionId', version.getId());
                        else
                            span.removeAttribute('versionId');
                        span.setAttribute('pageTitle', page.getLinktext());
                        var label = page.getPathString();
                        if (version)
                            label += ' (' + version.getModified() + ')';
                        jQuery(span).text(label);
                    }
                    else {
                        span.removeAttribute('pageId');
                        span.removeAttribute('versionId');
                        jQuery(span).text('');
                    }
                };

                $(document).on('click', 'ul#list_of_pages li', function () {
                    if ($(this).hasClass('selected')) {
                        $(this).removeClass('selected');
                        postID = 0;
                    } else {
                        $('ul#list_of_pages li').each(function () {
                            $(this).removeClass('selected');
                        });
                        $(this).addClass('selected');
                        postID = $(this).data('id');
                    }
                });

                infoTab.elements.push({
                    type: 'vbox',
                    id: 'contentOptions',
                    children: [{
                        type: 'html',
                        label: 'انتخاب صفحه',
                        html: selectPage(linkTypeSelect)
                    }, {
                        type: 'html',
                        id: 'contentPage',
                        html: '<span style="white-space: normal"></span>',
                        validate: function () {
                            if (postID == 0 && dontCheck !== true) {
                                alert('شما باید یک سفحه مقصد را انتخاب کنید.');
                                return false;
                            }
                        }
                    }]
                });

                linkTypeSelect.onChange = CKEDITOR.tools.override(linkTypeSelect.onChange, function (original) {
                    return function () {
                        original.call(this);
                        var dialog = this.getDialog();
                        var ourUIControls = dialog.getContentElement('info', 'contentOptions')
                            .getElement().getParent().getParent();
                        if (this.getValue() == 'content') {
                            ourUIControls.show();
                            if (editor.config.linkShowTargetTab)
                                dialog.showPage('target');
                            var uploadTab = dialog.definition.getContents('upload');
                            if (uploadTab && !uploadTab.hidden)
                                dialog.hidePage('upload');
                            dontCheck = false;
                        } else {
                            dontCheck = true;
                            ourUIControls.hide();
                        }
                    };
                });

                linkTypeSelect.setup = function (data) {
                    if (!data.type || (data.type == 'url') && !data.url) {
                        data.type = 'content';
                        setTargetPage(this.getDialog(), null);
                    } else if (data.url && !data.url.protocol && data.url.url) {
                        data.type = 'content';
                        var parsed = data.url.url.match(/(?:content|internal):\/\/(\d+)(?:#(\d+))?/);
                        ajaxSearch({post_id: parsed[1]});
                        delete data.url;
                    }
                    this.setValue(data.type);
                };

                linkTypeSelect.commit = function (data) {
                    data.type = this.getValue();
                    if (data.type == 'content') {
                        data.type = 'url';
                        var dialog = this.getDialog();
                        var link = "content://" + postID;
                        dialog.setValueOf('info', 'protocol', '');
                        dialog.setValueOf('info', 'url', link);
                        postID = 0;
                        $('ul#list_of_pages').empty();
                        $('#search_pages').val('');

                    }
                };
            });
        }
    });
})(jQuery);


function selectPage(l) {
    var style = '',
        html = '',
        ulPosts = '';

    $(document).on('keyup', '#search_pages', function () {
        var $search = $(this).val();
        if ($search.length > 2) {
            ajaxSearch({keyword: $search});
        }
    });

    style = '<style>' +
        'ul#list_of_pages { height: 150px; overflow: auto; margin:0; background-color:#f7f7f7; border: 1px solid #e2e2e2; padding: 5px; margin-top: 10px;}' +
        'ul#list_of_pages li { list-style: none; padding: 5px; margin: 1px; background-color:#e3e3e3;}' +
        'ul#list_of_pages li.selected { background-color:#cff7ff;}' +
        '</style>';
    ulPosts = '<ul id="list_of_pages"></ul>';
    html = style + '<input type="text" name="search_pages" id="search_pages" style="width: 100%;" class="cke_dialog_ui_input_text" placeholder="جستجو در صفحات ...">' + ulPosts;
    return html;

}

function ajaxSearch(search) {
    var $ulTag = $('#list_of_pages');
    $.ajax({
        url: _CKEDITOR_PLUGIN_CONTENT_AJAX_URL,
        type: 'get',
        dataType: 'json',
        data: search,
        method: 'GET',
        async: false,
        success: function (data) {
            $ulTag.empty();
            $.each(data, function (i, post) {
                if (search.post_id == post.id) {
                    $ulTag.append('<li class="selected" data-id="' + post.id + '">' + post.title + '</li>');
                    postID = post.id;
                } else {
                    $ulTag.append('<li data-id="' + post.id + '">' + post.title + '</li>');
                    postID = 0;
                }
            })
        }
    });
}