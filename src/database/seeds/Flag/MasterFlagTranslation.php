<?php

namespace Mekaeil\LaravelTranslation\src\database\seeds\Flag;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Mekaeil\LaravelTranslation\Repository\Contracts\FlagRepositoryInterface;


class MasterFlagTranslation extends Seeder
{

    protected $languages;
    private $flagRepository;

    public function __construct(FlagRepositoryInterface $repository)
    {
        $this->flagRepository = $repository;
    }

    protected function getLanguages(){
        return $this->languages;
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
        $this->command->info('                INSERTING FLAG TRANSLATION                ');
        $this->command->info('==========================================================');
        $this->command->info("\n");


        foreach ( $this->getLanguages() as $lang )
        {

            $findLang = $this->flagRepository->getRecord([
                'name'      => $lang['name']
            ], true);

            if ($findLang)
            {
                $this->command->info('THIS LANGUAGE << '. $lang['name'] .' >> EXISTED, UPDATING DATA....');

                $this->flagRepository->update($findLang->id,[
                    'name'          => $lang['name'],
                    'display_name'  => $lang['display_name'],
                    'status'        => $lang['status'] ?? false,
                    'default'       => $lang['default'] ?? false,
                ]);
                continue;
            }

            $this->flagRepository->store([
                'name'          => $lang['name'],
                'display_name'  => $lang['display_name'],
                'status'        => $lang['status'],
                'default'       => $lang['default'],
            ]);

            $this->command->info('THIS LANGUAGE << '. $lang['name'] . ' >> CREATED!');

        }

        $this->command->info("\n");
        $this->command->info('==========================================================');
        $this->command->info('           FINALIZED INSERTING FLAG TRANSLATION           ');
        $this->command->info('==========================================================');
        $this->command->info("\n");

    }
}
