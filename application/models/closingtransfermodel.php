<?php

class closingtransfermodel extends CI_Model {

    public function getCurrentYear($currentYearId) {
        $data = array();
        $sql = "SELECT `financialyear`.`year`,`financialyear`.`id` ,financialyear.end_date FROM `financialyear` 
                WHERE `financialyear`.`id`=" . $currentYearId;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $data = array(
                "year" => $row->year,
                "currentyearid" => $row->id,
                "end_date" => $row->end_date,
                "next_year" => $this->nextAccountingYear($row->id, $row->end_date),
            );
        }
        return $data;
    }

    public function nextAccountingYear($id, $lastdate) {
        $nextyeardate = date('Y-m-d', strtotime('+1 day', strtotime($lastdate)));
        $sql = " SELECT `financialyear`.`year`,`financialyear`.`id`,DATE_FORMAT(`financialyear`.`end_date`,'%d-%m-%Y') AS end_date FROM 
            `financialyear`  WHERE `financialyear`.`start_date`='" . $nextyeardate . "'";
        $nextyear = "";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $nextyear = array("nextYear" => $row->year, "nextId" => $row->id);
        }
        return $nextyear;
    }

    public function transferclosingbalance($company, $fromyearid, $toyearid, $fromdate, $todate, $fiscalsatrtdate) {
        $data = array();
        try {

            $call_procedure = "CALL sp_closingbalancetransfer($company,$fromyearid," . "'" . $fromdate . "'" . "," . "'" . $todate . "'" . "," . "'" . $fiscalsatrtdate . "'," . $toyearid . ")";
            $query = $this->db->simple_query($call_procedure);
            if ($query) {
                $sql = "select `account_master`.`account_name`,`account_opening_master`.`opening_balance` 
                        FROM `account_master` 
                        LEFT JOIN `account_opening_master`  ON `account_master`.`id` = `account_opening_master`.`account_master_id`
                        WHERE `account_opening_master`.`company_id`=" . $company . 
                        " AND `account_opening_master`.`financialyear_id`=" . $toyearid . " ORDER BY `account_master`.`account_name`";

                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                    foreach ($query->result() as $rows) {
                        $data[] = array(
                            "account_name" => $rows->account_name,
                            "opening_balance" => $rows->opening_balance
                        );
                    }
                    return $data;
                }
            } else {
                return $data;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}

?>