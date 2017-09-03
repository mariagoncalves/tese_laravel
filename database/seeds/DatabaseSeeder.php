<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*

        $this->call(LanguageTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PropUnitTypeTableSeeder::class);
        // $this->call(PropUnitTypeNameTableSeeder::class); (Remover)
        $this->call(ProcessTypeTableSeeder::class);
        // $this->call(ProcessTypeNameTableSeeder::class); (Remover)
        $this->call(CustomFormTableSeeder::class);
        // $this->call(CustomFormNameTableSeeder::class); (Remover)
        $this->call(RoleTableSeeder::class);
        // $this->call(RoleNameTableSeeder::class); (Remover)
        $this->call(ActorTableSeeder::class);
        // $this->call(ActorNameTableSeeder::class); (Remover)
        $this->call(RoleHasActorTableSeeder::class);
        $this->call(RoleHasUserTableSeeder::class);
        $this->call(ProcessTableSeeder::class);
        // $this->call(ProcessNameTableSeeder::class); (Remover)

        $this->call(TStateTableSeeder::class);
        // $this->call(TStateNameTableSeeder::class); (Remover)

        $this->call(TransactionTypeTableSeeder::class);
        // $this->call(TransactionTypeNameTableSeeder::class); (Remover)

        $this->call(EntTypeTableSeeder::class);
        // $this->call(EntTypeNameTableSeeder::class); (Remover)

        $this->call(EntityTableSeeder::class);a
        // $this->call(EntityNameTableSeeder::class); (Remover)

        $this->call(RelTypeTableSeeder::class);
        // $this->call(RelTypeNameTableSeeder::class); (Remover)
        
        $this->call(RelationTableSeeder::class); // (Falta Alterar)
        $this->call(RelationNameTableSeeder::class); // (Falta Alterar)

        $this->call(TransactionTableSeeder::class);
        $this->call(TransactionStateTableSeeder::class);
        $this->call(TransactionAckTableSeeder::class);

        $this->call(ActorIniciatesTTableSeeder::class);
         */
        
        $this->call(PropertyTableSeeder::class);
        // $this->call(PropertyNameTableSeeder::class); (Remover)

        /*
        $this->call(PropertyTableSeeder::class);
        $this->call(PropertyNameTableSeeder::class);
        $this->call(ValueTableSeeder::class);
        $this->call(ValueNameTableSeeder::class);
        $this->call(PropAllowedValueTableSeeder::class);
        $this->call(PropAllowedValueNameTableSeeder::class);
        $this->call(CustomFormHasPropTableSeeder::class);
        $this->call(CausalLinkTableSeeder::class);
        $this->call(WaitingLinkTableSeeder::class);*/
    }
}
