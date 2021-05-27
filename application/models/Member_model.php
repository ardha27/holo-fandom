<?php

class Member_model extends CI_Model
{
    public function getMember($id = NULL)
    {
        if ($id === NULL) {
            return $this->db->get('member')->result_array();
        } else {
            return $this->db->get_where('member', ['id' => $id])->result_array();
        }
    }

    public function deleteMember($id) 
    {
        $this->db->delete('member', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function createMember($data)
    {
        $this->db->insert('member', $data);
        return $this->db->affected_rows();
    }

    public function updateMember($data, $id)
    {
        $this->db->update('member', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}