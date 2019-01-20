<?php

namespace Mekaeil\LaravelTranslation\database\seeds\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Mekaeil\LaravelTranslation\Repository\Contracts\BaseRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Contracts\FlagRepositoryInterface;

class MasterBaseTranslation extends Seeder
{

    protected $translations;
    private $baseRepository;
    private $flagRepository;

    public function __construct(BaseRepositoryInterface $repository, FlagRepositoryInterface $langRepo)
    {
        $this->baseRepository = $repository;
        $this->flagRepository = $langRepo;
    }

    protected function getTranslations(){
        return $this->translations;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->command->info('==========================================================');
        $this->command->info('            INSERTING BASE TRANSLATION KEYWORDS           ');
        $this->command->info('==========================================================');
        $this->command->info("\n");


        foreach ( $this->getTranslations() as $trans )
        {

            // FIND LANGUAGE
            ///////////////////////////////////////////////////////////////////////////////////////
            $findLanguage = $this->flagRepository->getRecord([
                'name'       => $trans['locale']
            ], true);

            if (! $findLanguage)
            {
                $this->command->info('!!!!!!! ERROR! THE LANGUAGE <<'. $trans['lang'] .'>> NOT EXISTED IN DB ');
                continue;
            }
            ///////////////////////////////////////////////////////////////////////////////////////

            $findTrans = $this->baseRepository->getRecord([
                'key'       => $trans['key'],
                'locale'    => $trans['locale'],
            ], true);

            if ($findTrans)
            {
                $this->command->info('THIS BASE WORD << '. $trans['key'] . ' >> WITH LOCALE << '. $trans['locale'] .' >> EXISTED, UPDATING DATA....');

                $this->baseRepository->update($findTrans->id,[
                    'key'       => $trans['key'],
                    'value'     => $trans['value'],
                    'locale'    => $trans['locale'],
                    'lang'      => $findLanguage->id,
                ]);

                continue;
            }

            $this->baseRepository->store([
                'key'       => $trans['key'],
                'value'     => $trans['value'],
                'locale'    => $trans['locale'],
                'lang'      => $findLanguage->id,
            ]);

            $this->command->info('THIS BASE WORD << '. $trans['key'] . ' >> WITH LOCALE << '. $trans['locale'] .' >> CREATED!');

        }

        $this->command->info("\n");
        $this->command->info('==========================================================');
        $this->command->info('       FINALIZED INSERTING BASE TRANSLATION KEYWORDS      ');
        $this->command->info('==========================================================');
        $this->command->info("\n");

    }
}
