<?php

namespace Mekaeil\LaravelTranslation\Http\Controller;

use Illuminate\Http\Request;
use Mekaeil\LaravelTranslation\Http\Requests\Language\StoreLanguage;
use Mekaeil\LaravelTranslation\Http\Requests\Language\UpdateLanguage;
use Mekaeil\LaravelTranslation\Models\FlagTranslation;
use Mekaeil\LaravelTranslation\Repository\Contracts\FlagRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Contracts\UserRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Facade\Translation;

class FlagTranslateController extends CoreTranslateController
{
    private $flagRepository;
    private $userRepository;

    public function __construct(
        FlagRepositoryInterface $flagRepo,
        UserRepositoryInterface $userRepo
    )
    {
        $this->flagRepository = $flagRepo;
        $this->userRepository = $userRepo;
    }

    public function index()
    {
        $languages = $this->flagRepository->all();
        return view('LaraTrans::Languages.index',compact('languages'));
    }

    public function create()
    {
        return view('LaraTrans::Languages.create');
    }

    public function store(StoreLanguage $request)
    {

        $language = $this->flagRepository->store([
            'name'          => $request->name,
            'display_name'  => $request->display_name,
            'status'        => isset($request->status) ? true : false,
            'default'       => false,
        ]);

        return redirect()->route(config('laravel-translation.languages_index'))->with('message',[
            'type'  => 'success',
            'text'  => "This language ' $language->name ' added successfully!",
        ]);

    }

    public function edit(FlagTranslation $lang)
    {
        return view('LaraTrans::Languages.edit', compact('lang'));
    }

    public function update(UpdateLanguage $request ,FlagTranslation $lang)
    {

        $this->flagRepository->update($lang->id,[
            'display_name'  => $request->display_name,
            'status'        => $request->status ? true : false,
        ]);

        return redirect()->route(config('laravel-translation.languages_index'))->with('message',[
            'type'  => 'success',
            'text'  => "This language ' $lang->name ' updated successfully!",
        ]);
    }

    public function setDefault(FlagTranslation $lang)
    {

        /// REMOVE PREVIOUS DEFAULT LANGUAGE
        //////////////////////////////////////////////////////////////////
        $findDefaultLanguage = $this->flagRepository->getRecord([
            'default'   => true,
        ],true);

        if ($findDefaultLanguage){
            $this->flagRepository->update($findDefaultLanguage->id,[
                'default'   => false,
            ]);
        }
        //////////////////////////////////////////////////////////////////

        $this->flagRepository->update($lang->id,[
            'default'   => true,
            'status'    => true,
        ]);

        return redirect()->route(config('laravel-translation.languages_index'))->with('message',[
            'type'  => 'success',
            'text'  => "This language ' $lang->name ' set as Default language in your website successfully!",
        ]);

    }

    public function delete(FlagTranslation $lang)
    {
        $language = $lang->display_name;

        $this->flagRepository->delete($lang->id);

        return redirect()->route(config('laravel-translation.languages_index'))->with('message',[
            'type'  => 'warning',
            'text'  => "This language ' $language ' DELETED successfully!",
        ]);
    }

    public function switchLanguage(Request $request)
    {

        $userID     = $request->userID ?? null;
        $langName   = $request->lang ?? null;

        if ($langName && $getLanguage=$this->flagRepository->getRecord(['name'=> $request->lang]))
        {

            Translation::clearCache(['language','direction','assets']);

            //// CHANGE USER DEFAULT LANGUAGE AND SET COOKIES
            ////////////////////////////////////////////////////////////////
            if ($userID && $user=$this->userRepository->find($userID))
            {
                Translation::setUserLocale($userID,$getLanguage->id);
                return response()->json("Switch Language to $getLanguage->display_name for user with id=$userID ");
            }

            Translation::setUserLocale(null,$getLanguage->id);
            return response()->json("Switch language to $getLanguage->display_name");
        }

        return response()->json('Language not found!!!');

    }

}
