<?php
defined('BASEPATH') or exit('Keluar dari sistem ini....!!');

class M_crud extends CI_Model
{

    public function __construct()
    { }

    public function getSemua($table)
    {
        return $this->db->get($table)->result();
    }



    public function getN($table, $kolom, $id)
    {
        return $this->db->where($kolom, $id)->get($table)->result();
    }


    public function tambah($table, $data)
    {
        $this->db->insert($table, $data);
    }



    public function hapus($table, $variabel)
    {
        $this->db->delete($table, $variabel);
    }

    public function update($table, $data, $variabel)
    {
        $this->db->update($table, $data, $variabel);
    }
}
