<?php
class adeptos_model extends CI_Model
{

    public function add_adepto_main($adepto_data)
    {
        return $this->db->insert('adeptos_main', $adepto_data);
    }

    public function get_adepto_main($adepto_id)
    {

        $this->db->where('id', $adepto_id);
        return $this->db->get('adeptos_main')->row_array();
    }

    public function get_adeptos_mains($adepto_persistence = null, $adepto_cve = null, $adepto_active = null)
    {


        if ($adepto_persistence != null) {
            $this->db->where('adepto_persistence', $adepto_persistence);
        }

        if ($adepto_cve != null) {
            $this->db->where('adepto_cve', $adepto_cve);
        }

        if ($adepto_active != null) {
            $this->db->where('adepto_active', $adepto_active);
        }


        $this->db->where('is_deleted', 0);
        return $this->db->get('adeptos_main')->result();
    }

    public function check_adepto_main_by_site($adepto_site)
    {
        $this->db->where('adepto_site', $adepto_site);
        return $this->db->get('adeptos_main')->row_array();
    }


    public function update_adepto_main($id, $data)
    {
        
        $this->db->where('id', $id);
        return $this->db->update('adeptos_main', $data);
    }

    public function delete_adepto_main($adepto_id)
    {


        $this->db->where('id', $adepto_id);

        $data = array(
            'is_deleted' => 0
        );

        return $this->db->update('adeptos_main', $data);
    }
}
