<?php

namespace Mekaeil\LaravelTranslation\Http\Controller;

use Illuminate\Http\Request;
use Mekaeil\LaravelTranslation\Http\Requests\Asset\StoreAssets;
use Mekaeil\LaravelTranslation\Http\Requests\Asset\UpdateAsset;
use Mekaeil\LaravelTranslation\Models\AssetTranslation;
use Mekaeil\LaravelTranslation\Models\BaseTranslation;
use Mekaeil\LaravelTranslation\Repository\Contracts\AssetRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Contracts\FlagRepositoryInterface;
use Mekaeil\LaravelTranslation\Http\Requests\BaseWord\UpdateBaseWords;

class AssetsTranslateController extends CoreTranslateController
{

    private $assetRepository;
    private $flagRepository;

    public function __construct(
        AssetRepositoryInterface $assetRepo,
        FlagRepositoryInterface $flagRepo
    )
    {
        $this->assetRepository= $assetRepo;
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

        $assets     = $this->assetRepository->all([],[],25, $condition);
        $languages  = $this->flagRepository->pluckData('display_name' , 'id' , true, [
            'status'    =>  true,
        ]);

        return view('LaraTrans::Assets.index', compact('assets','languages'));
    }

    public function create()
    {
        $languages  = $this->flagRepository->pluckData('display_name' , 'id' , true, [
            'status'    => true,
        ]);

        $types          = $this->assetRepository->getAssetTypes();
        $pathType       = $this->assetRepository->getPathType();
        $positionAssets = $this->assetRepository->getPositionStyle();

        return view('LaraTrans::Assets.create', compact('languages','types','pathType','positionAssets'));
    }

    public function store(StoreAssets $request)
    {

        $language   = $this->flagRepository->find($request->lang);
        $ifExist    = $this->assetRepository->getRecord([
            'lang_id'   => $language->id,
            'type'      => $request->type,
            'where'     => $request->where,
        ],true);

        // TO DO #Mekaeil , set message with trans()

        if ($ifExist){
            return redirect()->back()->with('message',[
                'type'  => 'danger',
                'text'  => 'This asset Exist! please add new asset.'
            ]);
        }

        $asset = $this->assetRepository->store([
            'lang_id'   => $language->id,
            'source'    => $request->source,
            'type'      => $request->type,
            'where'     => $request->where,
            'status'    => $request->status ? 1 : 0,
        ]);

        return redirect()->route(config('laravel-translation.assets_index'))->with('message',[
            'type'  => 'success',
            'text'  => "This asset << $asset->source >> added successfully in ' $asset->where ' !",
        ]);
    }

    public function edit(AssetTranslation $asset)
    {
        $languages  = $this->flagRepository->pluckData('display_name' , 'id' , true, [
            'status'    => true,
        ]);
        $types          = $this->assetRepository->getAssetTypes();
        $pathType       = $this->assetRepository->getPathType();
        $positionAssets = $this->assetRepository->getPositionStyle();

        return view('LaraTrans::Assets.edit', compact(
            'asset',
                 'languages',
                    'types',
                    'pathType',
                    'positionAssets'));
    }

    public function update(UpdateAsset $request ,AssetTranslation $asset)
    {
        $language   = $this->flagRepository->find($request->lang);

        $this->assetRepository->update($asset->id,[
            'lang_id'   => $language->id,
            'source'    => $request->source,
            'type'      => $request->type,
            'where'     => $request->where,
            'status'    => $request->status ? 1 : 0,
        ]);

        return redirect()->route(config('laravel-translation.assets_index'))->with('message',[
            'type'  => 'success',
            'text'  => "This asset << $asset->source >> updated successfully in ' $asset->where ' !",
        ]);
    }


    public function delete(AssetTranslation $asset)
    {
        $assetSource = $asset->source;
        $this->assetRepository->delete($asset->id);

        return redirect()->route(config('laravel-translation.assets_index'))->with('message',[
            'type'  => 'warning',
            'text'  => "This asset << $assetSource >> DELETED successfully!",
        ]);
    }


}
