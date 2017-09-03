<?php

use Illuminate\Database\Seeder;
use App\TransactionType;
use App\TransactionTypeName;

class TransactionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ['Decisao sobre cedencia de transporte', 'Decisao sobre cedencia de transporte foi efetuada'],
            ['Decisão sobre apoios', 'Decisão sobre apoios foi efetuada'],
            ['Solicitação de pedido', 'Solicitação de pedido foi efetuada']
        ];

        foreach ($datas as $data) {
            $new = factory(TransactionType::class, 1)->create();

            factory(TransactionTypeName::class, 1)->create([
                'transaction_type_id' => $new->id,
                'language_id' => App\Language::where('slug', 'pt')->first()->id, 
                't_name'      => $data[0],
                'rt_name'     => $data[1],
                'updated_by'  => $new->updated_by,
            ]);
        }
    }
}
