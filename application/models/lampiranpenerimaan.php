<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
* 
*/
class Lampiranpenerimaan extends CI_Model
{
	
    public function get_Download($kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$bulan,$kd_pengadaan)
	{

        $querypengadaan = "SELECT a.*, b.kd_supplier, b.nama_supplier, c.kd_belanja, c.nama_belanja FROM tb_pengadaan a join tb_supplier b on b.kd_urusan=a.kd_urusan and b.kd_bidang=a.kd_bidang and b.kd_unit=a.kd_unit and b.kd_sub=a.kd_sub and b.kd_supplier=a.kd_supplier join tb_belanja c on c.kd_belanja=a.kd_belanja where a.kd_urusan='$kd_urusan' and a.kd_bidang='$kd_bidang' and a.kd_unit='$kd_unit' and a.kd_sub='$kd_sub' and a.tahun='$tahun' and a.bulan='$bulan' and a.kd_pengadaan='$kd_pengadaan'
                ";
        $pengadaan=$this->db->query($querypengadaan)->row_array();

        $querypenerimaan = "SELECT * FROM tb_penerimaan where kd_urusan='$kd_urusan' and kd_bidang='$kd_bidang' and kd_unit='$kd_unit' and kd_sub='$kd_sub' and tahun='$tahun' and bulan='$bulan' and kd_pengadaan='$kd_pengadaan'";

        $penerimaan=$this->db->query($querypenerimaan)->result_array();
     

    
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));
        $this->db->where($array);
        $res2 = $this->db->get('tb_skpd')->row_array();

        $this->db->where($array);
        $this->db->where('kd_jabatan','1');
        $res5 = $this->db->get('tb_penanggung_jawab')->row_array();

        $this->db->where($array);
        $this->db->where('kd_jabatan','3');
        $res7 = $this->db->get('tb_penanggung_jawab')->row_array();
       
    

        $final_res['pengadaan']=$pengadaan;
        $final_res['penerimaan']=$penerimaan;
        $final_res['skpd']=$res2;
        $final_res['pj1']=$res5;
        $final_res['pj3']=$res7;

        $data['list']=$final_res;

        // $this->load->view('pengadaan/lampiran', $data);
        // // die;
    
        $rand=rand(1,100);
        $namafile='lampiran'.$rand;
        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('pengadaan/lampiran',$data,true);
        $mpdf->AddPage('L');
        $mpdf->WriteHTML($html);
        $mpdf->Output($namafile,"I");
        exit();
        
        // echo "<script>window.open('https://www.w3schools.com','_blank');</script>";
    }
    

   
}

?>