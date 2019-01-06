<?php

namespace Mekaeil\LaravelTranslation\Http\Controller;

use Illuminate\Http\Request;
use Mekaeil\LaravelTranslation\Repository\Contracts\FlagRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Contracts\ModuleRepositoryInterface;

class ModuleTranslateController extends CoreTranslateController
{
    private $moduleRepository;
    private $flagRepository;

    public function __construct(
        ModuleRepositoryInterface $repository,
        FlagRepositoryInterface $flagRepo
    )
    {
        $this->moduleRepository = $repository;
        $this->flagRepository   = $flagRepo;
    }

    public function index(Request $request)
    {

        $condition = array();
        if ($request->lang)
        {
            $condition = array_merge($condition,[
                'lang_id' => $request->lang,
            ]);
        }

        $sentences  = $this->moduleRepository->all([],[],25, $condition);
        $languages  = $this->flagRepository->pluckData('display_name' , 'id' , true, []);

        return view('LaraTrans::ModuleWords.index', compact('sentences','languages'));
    }

}
