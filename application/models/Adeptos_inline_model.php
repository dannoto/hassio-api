<?php
class adeptos_inline_model extends CI_Model
{

    public function add_adepto_inline($adepto_data)
    {
        return $this->db->insert('adeptos_inline', $adepto_data);
    }

    public function get_adepto_inline($adepto_id)
    {

        $this->db->where('id', $adepto_id);
        return $this->db->get('adeptos_inline')->row_array();
    }

    public function get_adeptos_inlines($adepto_processed = null, $adepto_cve = null)
    {

        if ($adepto_processed != null) {
            $this->db->where('adepto_processed', $adepto_processed);
        }

        if ($adepto_cve != null) {
            $this->db->where('adepto_cve', $adepto_cve);
        }

        $this->db->where('is_deleted', 1);
        return $this->db->get('adeptos_inline')->result();
    }

    public function check_adepto_inline_by_site($adepto_site)
    {
        $this->db->where('adepto_site', $adepto_site);
        return $this->db->get('adeptos_inline')->row_array();
    }

    public function update_adepto_inline($id, $data)
    {

        $this->db->where('id', $id);        
        return $this->db->update('adeptos_inline', $data);
    }

    public function delete_adepto_inline($adepto_id)
    {

        $this->db->where('id', $adepto_id);

        $data = array(
            'is_deleted' => 2
        );

        return $this->db->update('adeptos_inline', $data);
    }
}
