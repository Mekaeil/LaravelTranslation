CKEDITOR.dialog.add('contentDialog', function (editor) {

    return {
        title: 'انتخاب محتوا',
        resizable: CKEDITOR.DIALOG_RESIZE_NONE,
        minWidth: 500,
        minHeight: 400,
        onShow: function () {
            // var data = editor.ajax.load('http://yasa.dev/public/admin/content/api/getPosts');

            // console.log(result);
            // alert('ok');
        },
        contents: [
            {
                id: 'tab1',
                label: 'First Tab',
                title: 'First Tab Title',
                elements: [
                    {
                        type: 'select',
                        label: 'انتخاب پست',
                        id: 'select_post',
                        items: getPosts(),
                        commit: function() {
                            data.style = this.getValue();
                        }
                    }
                    // {
                    //     type: 'html',
                    //     html: getPosts()
                    // }
                ]
            }
        ]
    };
});

function getPosts() {
    var result = [],
        selectBox = '',
        selectOptions = '';

    $.ajax({
        url: 'http://yasa.dev/public/admin/content/api/getPosts',
        type: 'get',
        dataType: 'json',
        async: false,
        success: function (data) {
            result = data;
            // $.each(data, function (i, post) {
            //     selectOptions += '<option value="' + post.id + '">' + post.title + '</option>';
            // })
        }
    });

    // selectBox = '<select>' + selectOptions + '</select>';
    // console.log(result);
    // return selectBox;
    return result;
}