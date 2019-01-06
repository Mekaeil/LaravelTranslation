<?php

namespace Mekaeil\LaravelTranslation\Http\Controller;

use Illuminate\Http\Request;
use Mekaeil\LaravelTranslation\Models\BaseTranslation;
use Mekaeil\LaravelTranslation\Repository\Contracts\BaseRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Contracts\FlagRepositoryInterface;
use Mekaeil\LaravelTranslation\Http\Requests\BaseWord\StoreBaseWord;
use Mekaeil\LaravelTranslation\Http\Requests\BaseWord\UpdateBaseWords;

class BaseTranslateController extends CoreTranslateController
{

    private $baseRepository;
    private $flagRepository;

    public function __construct(
        BaseRepositoryInterface $repository,
        FlagRepositoryInterface $flagRepo
    )
    {
        $this->baseRepository = $repository;
        $this->flagRepository = $flagRepo;
    }

    public function index(Request $request)
    {

        $condition = array();
        if ($request->lang)
        {
            $condition = array_merge($condition,[
               'lang' => $request->lang,
            ]);
        }

        $words      = $this->baseRepository->all([],[],25, $condition);
        $languages  = $this->flagRepository->pluckData('display_name' , 'id' , true, []);

        return view('LaraTrans::BaseWords.index', compact('words','languages'));
    }

    public function create()
    {
        $languages  = $this->flagRepository->pluckData('display_name' , 'id' , true, [
            'status'    => true,
        ]);

        return view('LaraTrans::BaseWords.create', compact('languages'));
    }

    public function store(StoreBaseWord $request)
    {

        $locale  = $this->flagRepository->find($request->lang);
        $ifExist = $this->baseRepository->getRecord([
            'key'       => $request->key,
            'locale'    => $locale->name,
        ],true);

        // TO DO #Mekaeil , set message with trans()

        if ($ifExist){
            return redirect()->back()->with('message',[
                'type'  => 'danger',
                'text'  => 'This word Exist! please add new word.'
            ]);
        }

        $word = $this->baseRepository->store([
            'key'   => $request->key,
            'lang'  => $request->lang,
            'locale'=> $locale->name,
            'value' => $request->value,
        ]);

        return redirect()->route(config('laravel-translation.base_word_index'))->with('message',[
            'type'  => 'success',
            'text'  => "This word ' $word->key ' added successfully!",
        ]);
    }

    public function edit(BaseTranslation $trans)
    {
        $languages  = $this->flagRepository->pluckData('display_name' , 'id' , true, [
            'status'    => true,
        ]);
        return view('LaraTrans::BaseWords.edit', compact('trans','languages'));
    }


    public function update(UpdateBaseWords $request ,BaseTranslation $trans)
    {
        if ($trans->key != $request->key){

            $ifExist = $this->baseRepository->getRecord([
                'key'       => $request->key,
                'locale'    => $trans->locale,
            ],true);

            if ($ifExist){
                return redirect()->back()->with('message',[
                    'type'  => 'danger',
                    'text'  => 'This word Exist! please add new word.'
                ]);
            }
        }

        $this->baseRepository->update($trans->id,[
            'key'   => $request->key,
            'value' => $request->value,
        ]);

        return redirect()->route(config('laravel-translation.base_word_index'))->with('message',[
            'type'  => 'success',
            'text'  => "This word ' $trans->key ' updated successfully!",
        ]);
    }


    public function delete(BaseTranslation $trans)
    {
        $wordKey = $trans->key;

        $this->baseRepository->delete($trans->id);

        return redirect()->route(config('laravel-translation.base_word_index'))->with('message',[
            'type'  => 'warning',
            'text'  => "This word ' $wordKey ' DELETED successfully!",
        ]);
    }


}
