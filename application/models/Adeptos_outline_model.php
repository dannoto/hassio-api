<?php
class adeptos_outline_model extends CI_Model
{

    public function add_adepto_outline($adepto_data)
    {
        return $this->db->insert('adeptos_outline', $adepto_data);
    }

    public function get_adepto_outline($adepto_id)
    {

        $this->db->where('id', $adepto_id);
        return $this->db->get('adeptos_outline')->row_array();
    }

    public function get_adeptos_outlines($adepto_processed = null, $adepto_cve = null)
    {

        if ($adepto_processed != null) {
            $this->db->where('adepto_processed', $adepto_processed);
        }

        if ($adepto_cve != null) {
            $this->db->where('adepto_cve', $adepto_cve);
        }

        $this->db->where('is_deleted', 1);

        return $this->db->get('adeptos_outline')->result();
    }

    public function check_adepto_outline_by_site($adepto_site)
    {
        $this->db->where('adepto_site', $adepto_site);
        return $this->db->get('adeptos_outline')->row_array();
    }

    public function update_adepto_outline($id, $data)
    {

        $this->db->where('id', $id);


        return $this->db->update('adeptos_outline', $data);
    }

    public function delete_adepto_outline($adepto_id)
    {

        $this->db->where('id', $adepto_id);

        $data = array(
            'is_deleted' => 2
        );

        return $this->db->update('adeptos_outline', $data);
    }
}
