<?php

namespace App\Models;

use CodeIgniter\Model;

class TaxForm extends Model
{

    protected $table = 'tax_form';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id','address', 'payers_tin', 'recipients_tin', 'recipients_name', 'street_address' , 'city_or_town_state_or_province_country', 'account_number', 'rents', 'royalties', 'other_income','federal_income_tax_withheld', 'fishing_boat_proceeds', 'medical_and_health_care_payments', 'payer_made_direct', 'substitute_payments', 'crop_insurance_proceeds', 'gross_proceeds', 'fish_purchased_for_resale', 'section_409A_deferrals', 'fatca_filing_requirement', 'excess_golden', 'nonqualified_deferred_compensation', 'state_tax_withheld', 'State_or_Payers_state_no', 'state_income', '2nd_tin_not', 'created_at','updated_at'];

    public function get_By_UserId($id){
        $this->select('*');
        $this->where("user_id = '$id'");
        $query = $this->findAll();
        return $query;
    }

    
}
