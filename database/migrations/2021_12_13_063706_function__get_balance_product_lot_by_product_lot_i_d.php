<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FunctionGetBalanceProductLotByProductLotID extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE FUNCTION `getBalanceProductLotByProductLotID`(`Pro_Lot_id` INT) RETURNS DECIMAL(18, 3)
            BEGIN
                DECLARE lot_qty   DECIMAL(18, 3);
                DECLARE lot_cut   DECIMAL(18, 3);
                DECLARE lot_sum   DECIMAL(18, 3);

                    SELECT  sum(pl.qty) INTO lot_qty
                    FROM 	product_lots pl
                    WHERE   pl.id = Pro_Lot_id
                    AND pl.action=3;
                        IF (lot_qty is null) THEN
                            set lot_qty = 0;
                        end if;

                    SELECT sum(pc.qty) INTO lot_cut
                    FROM product_cuts pc
                    WHERE pc.action = 1
                    AND pc.reserve = 1
                    AND pc.product_lot_id = Pro_Lot_id;
                        IF (lot_cut is null) THEN
                            set lot_cut = 0;
                        end if;

                    SET lot_sum = lot_qty - lot_cut;

                RETURN lot_sum;

            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION getBalanceProductLotByProductLotID');
    }
}
