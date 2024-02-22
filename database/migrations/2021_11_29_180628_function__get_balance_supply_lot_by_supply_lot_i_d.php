<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FunctionGetBalanceSupplyLotBySupplyLotID extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE FUNCTION `getBalanceSupplyLotBySupplyLotID`(`Sup_Lot_id` INT) RETURNS DECIMAL(18, 3)
            BEGIN
                DECLARE lot_qty   DECIMAL(18, 3);
                DECLARE lot_cut   DECIMAL(18, 3);
                DECLARE lot_sum   DECIMAL(18, 3);

                    SELECT  sum(s.qty) INTO lot_qty
                    FROM 	supply_lots s
                    WHERE   s.id = Sup_Lot_id
                    AND s.action=2;
                        IF (lot_qty is null) THEN
                            set lot_qty = 0;
                        end if;

                    SELECT sum(sc.qty) INTO lot_cut
                    FROM supply_cuts sc
                    WHERE sc.action = 1
                    AND sc.reserve = 1
                    AND sc.supply_lot_id = Sup_Lot_id;
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
        DB::unprepared('DROP FUNCTION getBalanceSupplyLotBySupplyLotID');
    }
}
