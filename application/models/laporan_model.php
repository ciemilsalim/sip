<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
* 
*/
class Laporan_model extends CI_Model
{
	public function get_Download_supplier($action)
	{
        if ($action == "") 
        {
            redirect('laporan/parameter', 'refresh');
        }

        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));
        $this->db->where($array);
        $res1 = $this->db->get('tb_supplier')->result_array();

        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));
        $this->db->where($array);
        $res2 = $this->db->get('tb_skpd')->row_array();

        $test = "pdf";
        $final_res = array();
        
        if ($action == 'pdf') 
        {
            $final_res['action'] = $action;
        } elseif ($action == 'excel') 
        {
            $final_res['action'] = $action;
        }

        $final_res['supplier']=$res1;
        $final_res['skpd']=$res2;
         
        $data['list']=$final_res;
        $rand=rand(1,100);
        $namafile='laporansupplier'.$rand;
        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('laporan/supplier',$data,true);
        $mpdf->AddPage('P', '', '', '', '',
        20, // margin_left
        20, // margin right
        15, // margin top
        10, // margin bottom
        0, // margin header
        5); // margin footer
        $mpdf->SetHTMLFooter("<p style='font-size:0.6em; text-align:right;'><i>printedbySIPBuol</i></p>");
        $mpdf->WriteHTML($html);
        $mpdf->Output($namafile,"I");
        exit();
    }
    
    public function get_Download_belanja($action)
	{
        if ($action == "") 
        {
            redirect('laporan/parameter', 'refresh');
        }

        $res1 = $this->db->get('tb_belanja')->result_array();

        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));
        $this->db->where($array);
        $res2 = $this->db->get('tb_skpd')->row_array();

        $test = "pdf";
        $final_res = array();
        
        if ($action == 'pdf') 
        {
            $final_res['action'] = $action;
        } elseif ($action == 'excel') 
        {
            $final_res['action'] = $action;
        }

        $final_res['belanja']=$res1;
        $final_res['skpd']=$res2;
         
        $data['list']=$final_res;
        $rand=rand(1,100);
        $namafile='laporanbelanja'.$rand;
        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('laporan/belanja',$data,true);
        $mpdf->AddPage('P', '', '', '', '',
        20, // margin_left
        20, // margin right
        15, // margin top
        10, // margin bottom
        0, // margin header
        5); // margin footer
        $mpdf->SetHTMLFooter("<p style='font-size:0.6em; text-align:right;'><i>printedbySIPBuol</i></p>");
        $mpdf->WriteHTML($html);
        $mpdf->Output($namafile,"I");
        exit();
    }
    
    public function get_Download_jenis($action)
	{
        if ($action == "") 
        {
            redirect('laporan/komponen', 'refresh');
        }

        $this->db->order_by("jenis_komponen", "asc");
        $res1 = $this->db->get('tb_jenis_komponen')->result_array();


        // $test = "pdf";
        $final_res = array();
        
        $final_res['jenis']=$res1;
        $final_res['action'] = $action;
        $data['list']=$final_res;

        if ($action == 'pdf') 
        {
            $rand=rand(1,100);
            $namafile='laporanjenis'.$rand;
            $mpdf = new \Mpdf\Mpdf();
            $html = $this->load->view('laporan/jenis',$data,true);
            $mpdf->AddPage('P', '', '', '', '',
            20, // margin_left
            20, // margin right
            15, // margin top
            10, // margin bottom
            0, // margin header
            5); // margin footer
            $mpdf->SetHTMLFooter("<p style='font-size:0.6em; text-align:right;'><i>printedbySIPBuol</i></p>");
            $mpdf->WriteHTML($html);
            $mpdf->Output($namafile,"I");
            redirect('laporan/jenis');
        } 
        elseif ($action == 'excel') 
        {
            $this->load->view('laporan/jenis', $data);
        }    
      
    }
    
    public function get_Download_komponen($action)
	{
        if ($action == "") 
        {
            redirect('laporan/komponen', 'refresh');
        }

        $this->db->select('*');
        $this->db->from('tb_komponen');
        $this->db->join('tb_jenis_komponen', 'tb_jenis_komponen.id_jenis = tb_komponen.id_jenis', 'left');
        $this->db->order_by("jenis_komponen", "asc");
        $this->db->order_by("komponen", "asc");
        $res1  = $this->db->get()->result_array();

        $final_res = array();
        $final_res['komponen']=$res1;
        $final_res['action'] = $action;
        $data['list']=$final_res;
        
        
        if ($action == 'pdf') 
        {
            $rand=rand(1,100);
            $namafile='laporanjenis'.$rand;
            $mpdf = new \Mpdf\Mpdf();
            $html = $this->load->view('laporan/komponenn',$data,true);
            $mpdf->AddPage('P', '', '', '', '',
            20, // margin_left
            20, // margin right
            15, // margin top
            10, // margin bottom
            0, // margin header
            5); // margin footer
            $mpdf->SetHTMLFooter("<p style='font-size:0.6em; text-align:right;'><i>printedbySIPBuol</i></p>");
            $mpdf->WriteHTML($html);
            $mpdf->Output($namafile,"I");
            redirect('laporan/komponen');
        } 
        elseif ($action == 'excel') 
        {
            $this->load->view('laporan/komponenn', $data);
        }    

       
        
    }
    
    public function get_Download_uraian($action)
	{
        if ($action == "") 
        {
            redirect('laporan/komponen', 'refresh');
        }

        $this->db->select('*');
        $this->db->from('tb_uraian_komponen');
        $this->db->join('tb_jenis_komponen', 'tb_jenis_komponen.id_jenis = tb_uraian_komponen.id_jenis', 'left');
        $this->db->join('tb_komponen', 'tb_komponen.id_komponen = tb_uraian_komponen.id_komponen', 'left');
        $this->db->order_by('tb_jenis_komponen.kd_jenis');
        $this->db->order_by('tb_komponen.kd_komponen');
        $this->db->order_by("jenis_komponen", "asc");
        $this->db->order_by("komponen", "asc");
        $this->db->order_by("uraian_komponen", "asc");
        $res1  = $this->db->get()->result_array();


        $final_res = array();
        $final_res['uraian']=$res1;
        $final_res['action'] = $action;
        $data['list']=$final_res;
        
        if ($action == 'pdf') 
        {
            $rand=rand(1,100);
            $namafile='laporanuraian'.$rand;
            $mpdf = new \Mpdf\Mpdf();
            $html = $this->load->view('laporan/uraian',$data,true);
            $mpdf->AddPage('P', '', '', '', '',
            20, // margin_left
            20, // margin right
            15, // margin top
            10, // margin bottom
            0, // margin header
            5); // margin footer
            $mpdf->SetHTMLFooter("<p style='font-size:0.6em; text-align:right;'><i>printedbySIPBuol</i></p>");
            $mpdf->WriteHTML($html);
            $mpdf->Output($namafile,"I");
            redirect('laporan/uraian');
        } 
        elseif ($action == 'excel') 
        {
            $this->load->view('laporan/uraian', $data);
        }    
        
    }
    

    // public function get_Download_pengadaan($action,$kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$bulan)
	// {
    //     if ($action == "") 
    //     {
    //         redirect('laporan/transaksi', 'refresh');
    //     }

    //     if($tw=='')
    //     {
    //         $query = "SELECT a.*, b.kd_supplier, b.nama_supplier, c.kd_belanja, c.nama_belanja FROM tb_pengadaan a join tb_supplier b on b.kd_urusan=a.kd_urusan and b.kd_bidang=a.kd_bidang and b.kd_unit=a.kd_unit and b.kd_sub=a.kd_sub and b.kd_supplier=a.kd_supplier join tb_belanja c on c.kd_urusan=a.kd_urusan and c.kd_bidang=a.kd_bidang and c.kd_unit=a.kd_unit and c.kd_sub=a.kd_sub and c.kd_belanja=a.kd_belanja where a.kd_urusan='$kd_urusan' and a.kd_bidang='$kd_bidang' and a.kd_unit='$kd_unit' and a.kd_sub='$kd_sub' and a.tahun='$tahun'
	// 	    ";
    //     }
    //     else
    //     {
    //         $query = "SELECT a.*, b.kd_supplier, b.nama_supplier, c.kd_belanja, c.nama_belanja FROM tb_pengadaan a join tb_supplier b on b.kd_urusan=a.kd_urusan and b.kd_bidang=a.kd_bidang and b.kd_unit=a.kd_unit and b.kd_sub=a.kd_sub and b.kd_supplier=a.kd_supplier join tb_belanja c on c.kd_urusan=a.kd_urusan and c.kd_bidang=a.kd_bidang and c.kd_unit=a.kd_unit and c.kd_sub=a.kd_sub and c.kd_belanja=a.kd_belanja where a.kd_urusan='$kd_urusan' and a.kd_bidang='$kd_bidang' and a.kd_unit='$kd_unit' and a.kd_sub='$kd_sub'
    //         ";
    //     }

    //     $res1= $this->db->query($query)->result_array();

    //     $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));
    //     $this->db->where($array);
    //     $res2 = $this->db->get('tb_skpd')->row_array();

    //     $test = "pdf";
    //     $final_res = array();
        
    //     if ($action == 'pdf') 
    //     {
    //         $final_res['action'] = $action;
    //     } elseif ($action == 'excel') 
    //     {
    //         $final_res['action'] = $action;
    //     }

    //     $final_res['pembelian']=$res1;
    //     $final_res['skpd']=$res2;

    //     $strtw='';
    //     if($tw=='1')
    //     {
    //         $strtw='I';
    //     }
    //     else if($tw=='2')
    //     {
    //         $strtw='II';
    //     }
    //     else if($tw=='3')
    //     {
    //         $strtw='III';
    //     }
    //     else if($tw=='4')
    //     {
    //         $strtw='IV';
    //     }

    //     $final_res['tw']=$strtw;
         
    //     return $final_res;
    // }
    

    public function get_Download_penerimaan($action,$kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$bulan)
	{
        if ($action == "") 
        {
            redirect('laporan/index', 'refresh');
        }

         //belanja
         $query4="SELECT DISTINCT a.kd_belanja, b.nama_belanja FROM tb_pengadaan a join tb_belanja b on b.kd_belanja=a.kd_belanja ORDER BY a.kd_belanja asc";

         $res4= $this->db->query($query4)->result_array();
 
         $pengadaan=array();
 

        if($bulan=='')
        {
            foreach($res4 as $key1=> $value1)//belanja
            {
                $pengadaan['uraian_belanja'][$value1['kd_belanja']]=$value1;

                $kd_belanja=$res4[$key1]['kd_belanja'];
                $querypengadaan = "SELECT a.*, b.kd_supplier, b.nama_supplier, c.kd_belanja, c.nama_belanja FROM tb_pengadaan a join tb_supplier b on b.kd_urusan=a.kd_urusan and b.kd_bidang=a.kd_bidang and b.kd_unit=a.kd_unit and b.kd_sub=a.kd_sub and b.kd_supplier=a.kd_supplier join tb_belanja c on c.kd_belanja=a.kd_belanja where a.kd_urusan='$kd_urusan' and a.kd_bidang='$kd_bidang' and a.kd_unit='$kd_unit' and a.kd_sub='$kd_sub' and a.tahun='$tahun' and c.kd_belanja='$kd_belanja'
                ";

                $tes=$this->db->query($querypengadaan)->result_array();
                $pengadaan['uraian_belanja'][$value1['kd_belanja']]['uraian_pengadaan']=$tes;
               
                foreach($tes as $key2=> $value2)//rincian penerimaan
                {
                   
                    $kd_pengadaan=$value2['kd_pengadaan'];
                    $querypenerimaan = "SELECT a.*, b.uraian_komponen, b.satuan, b.harga FROM tb_penerimaan a JOIN tb_uraian_komponen b on b.kd_jenis=a.kd_jenis and b.kd_komponen=a.kd_komponen and b.kd_uraian=a.kd_uraian where a.kd_urusan='$kd_urusan' and a.kd_bidang='$kd_bidang' and a.kd_unit='$kd_unit' and a.kd_sub='$kd_sub' and a.tahun='$tahun' and a.kd_pengadaan='$kd_pengadaan'";
                    $pengadaan['uraian_belanja'][$value1['kd_belanja']]['uraian_pengadaan'][$key2]['uraian_penerimaan']=$this->db->query($querypenerimaan)->result_array();
                   
                }
            
            }
        }
        else
        {
            foreach($res4 as $key1=> $value1)//belanja
            {
                $pengadaan['uraian_belanja'][$value1['kd_belanja']]=$value1;

                $kd_belanja=$res4[$key1]['kd_belanja'];
                $querypengadaan = "SELECT a.*, b.kd_supplier, b.nama_supplier, c.kd_belanja, c.nama_belanja FROM tb_pengadaan a join tb_supplier b on b.kd_urusan=a.kd_urusan and b.kd_bidang=a.kd_bidang and b.kd_unit=a.kd_unit and b.kd_sub=a.kd_sub and b.kd_supplier=a.kd_supplier join tb_belanja c on c.kd_belanja=a.kd_belanja where a.kd_urusan='$kd_urusan' and a.kd_bidang='$kd_bidang' and a.kd_unit='$kd_unit' and a.kd_sub='$kd_sub' and a.tahun='$tahun' and a.bulan='$bulan' and c.kd_belanja='$kd_belanja'
                ";

                $tes=$this->db->query($querypengadaan)->result_array();
                $pengadaan['uraian_belanja'][$value1['kd_belanja']]['uraian_pengadaan']=$tes;
               
                foreach($tes as $key2=> $value2)//rincian penerimaan
                {
                   
                    $kd_pengadaan=$value2['kd_pengadaan'];
                    $querypenerimaan = "SELECT a.*, b.uraian_komponen, b.satuan, b.harga FROM tb_penerimaan a JOIN tb_uraian_komponen b on b.kd_jenis=a.kd_jenis and b.kd_komponen=a.kd_komponen and b.kd_uraian=a.kd_uraian where a.kd_urusan='$kd_urusan' and a.kd_bidang='$kd_bidang' and a.kd_unit='$kd_unit' and a.kd_sub='$kd_sub' and a.tahun='$tahun' and a.bulan='$bulan' and a.kd_pengadaan='$kd_pengadaan'";
                    $pengadaan['uraian_belanja'][$value1['kd_belanja']]['uraian_pengadaan'][$key2]['uraian_penerimaan']=$this->db->query($querypenerimaan)->result_array();
                   
                }
            
            }

        }

        // echo "<pre>"; print_r($pengadaan);
        // die;
    
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));
        $this->db->where($array);
        $res2 = $this->db->get('tb_skpd')->row_array();

        $this->db->where($array);
        $this->db->where('kd_jabatan','1');
        $res5 = $this->db->get('tb_penanggung_jawab')->row_array();

        $this->db->where($array);
        $this->db->where('kd_jabatan','2');
        $res6 = $this->db->get('tb_penanggung_jawab')->row_array();

        $this->db->where($array);
        $this->db->where('kd_jabatan','3');
        $res7 = $this->db->get('tb_penanggung_jawab')->row_array();
       
        
        $test = "pdf";
        $final_res = array();
        $final_res['action'] = $action;
        $final_res['pengadaan']=$pengadaan;
        $final_res['skpd']=$res2;
        $final_res['pj1']=$res5;
        $final_res['pj2']=$res6;
        $final_res['pj3']=$res7;
        $final_res['bulan']=$bulan;
        $data['list']=$final_res;
        
        if ($action == 'pdf') 
        {
            
            $rand=rand(1,100);
            $namafile='laporanpenerimaan'.$rand;
            $mpdf = new \Mpdf\Mpdf();
            $html = $this->load->view('laporan/penerimaan',$data,true);
            $mpdf->AddPage('L', '', '', '', '',
            8, // margin_left
            8, // margin right
            8, // margin top
            8, // margin bottom
            0, // margin header
            5); // margin footer
            $mpdf->SetHTMLFooter("<p style='font-size:0.6em; text-align:right;'><i>printedbySIPBuol</i></p>");
            $mpdf->WriteHTML($html);
            $mpdf->Output($namafile,"I");
            redirect('laporan/penerimaan');
        } elseif ($action == 'excel') 
        {
            $this->load->view('laporan/penerimaan', $data);
        }

    }

    public function get_Download_saldoawal($action,$kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$bulan)
	{
        if ($bulan == "") 
        {
            die;
            redirect('laporan/index', 'refresh');
        }
      
        $array = array('kd_urusan' => $kd_urusan, 'kd_bidang' => $kd_bidang, 'kd_unit' => $kd_unit, 'kd_sub' => $kd_sub, 'tahun_saldo_awal' => $tahun,'bulan_saldo_awal' => $bulan);
        $this->db->where($array);
        $this->db->order_by('uraian_komponen');
        $res1 = $this->db->get('tb_saldo_awal')->result_array();
    
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));
        $this->db->where($array);
        $res2 = $this->db->get('tb_skpd')->row_array();

        $this->db->where($array);
        $this->db->where('kd_jabatan','1');
        $res5 = $this->db->get('tb_penanggung_jawab')->row_array();

        $this->db->where($array);
        $this->db->where('kd_jabatan','2');
        $res6 = $this->db->get('tb_penanggung_jawab')->row_array();

        $this->db->where($array);
        $this->db->where('kd_jabatan','3');
        $res7 = $this->db->get('tb_penanggung_jawab')->row_array();
       
        
        $test = "pdf";
        $final_res = array();
        $final_res['action'] = $action;
        $final_res['saldoawal']=$res1;
        $final_res['skpd']=$res2;
        $final_res['pj1']=$res5;
        $final_res['pj2']=$res6;
        $final_res['pj3']=$res7;
        $final_res['bulan']=$bulan;
        $data['list']=$final_res;
        
        if ($action == 'pdf') 
        {
            
            $rand=rand(1,100);
            $namafile='laporansaldoawal'.$rand;
            $mpdf = new \Mpdf\Mpdf();
            $html = $this->load->view('laporan/saldoawal',$data,true);
            $mpdf->AddPage('L', '', '', '', '',
            8, // margin_left
            8, // margin right
            8, // margin top
            8, // margin bottom
            0, // margin header
            5); // margin footer
            $mpdf->SetHTMLFooter("<p style='font-size:0.6em; text-align:right;'><i>printedbySIPBuol</i></p>");
            $mpdf->WriteHTML($html);
            $mpdf->Output($namafile,"I");
            redirect('laporan/saldoawal');
        } elseif ($action == 'excel') 
        {
            $this->load->view('laporan/saldoawal', $data);
        }

    }
    

    public function get_Download_pengeluaran($action,$kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$tw)
	{
        if ($action == "") 
        {
            redirect('laporan/transaksi', 'refresh');
        }

         //belanja
         $query4="SELECT DISTINCT b.kd_belanja, b.nama_belanja FROM tb_pengadaan a join tb_belanja b on b.kd_urusan=a.kd_urusan and b.kd_bidang=a.kd_bidang and b.kd_unit=a.kd_unit and b.kd_sub=a.kd_sub and b.kd_belanja=a.kd_belanja and b.tahun=a.tahun ORDER BY b.kd_belanja asc";

         $res4= $this->db->query($query4)->result_array();
 
         $pengeluaran=array();
 

        if($tw=='')
        {
            $querypengeluaran = "SELECT * FROM tb_pengeluaran where kd_urusan='$kd_urusan' and kd_bidang='$kd_bidang' and kd_unit='$kd_unit' and kd_sub='$kd_sub' and tahun='$tahun' ";
            $tes=$this->db->query($querypengeluaran)->result_array();

            $pengeluaran['uraian_pengeluaran']=$tes;

            foreach($tes as $key2=> $value2)//rincian penerimaan
            {
               
                $kd_pengeluaran=$value2['kd_pengeluaran'];
                $kd_bid_skpd=$value2['kd_bid_skpd'];
                $querydetil = "SELECT* FROM tb_detail_pengeluaran where kd_urusan='$kd_urusan' and kd_bidang='$kd_bidang' and kd_unit='$kd_unit' and kd_sub='$kd_sub' and tahun='$tahun' and kd_bid_skpd='$kd_bid_skpd' and kd_pengeluaran='$kd_pengeluaran'";
                $pengeluaran['uraian_pengeluaran'][$key2]['detil']=$this->db->query($querydetil)->result_array();
               
            }
        }
        else
        {
            $querypengeluaran = "SELECT * FROM tb_pengeluaran where kd_urusan='$kd_urusan' and kd_bidang='$kd_bidang' and kd_unit='$kd_unit' and kd_sub='$kd_sub' and tahun='$tahun' and tw='$tw'";
            $tes=$this->db->query($querypengeluaran)->result_array();

            $pengeluaran['uraian_pengeluaran']=$tes;

            foreach($tes as $key2=> $value2)//rincian penerimaan
            {
               
                $kd_pengeluaran=$value2['kd_pengeluaran'];
                $kd_bid_skpd=$value2['kd_bid_skpd'];
                $kd_permintaan=$value2['kd_permintaan'];

                $querypermintaan= "SELECT* FROM tb_permintaan where kd_urusan='$kd_urusan' and kd_bidang='$kd_bidang' and kd_unit='$kd_unit' and kd_sub='$kd_sub' and tahun='$tahun' and tw='$tw' and kd_bid_skpd='$kd_bid_skpd' and kd_permintaan='$kd_permintaan'";
                $hasil=$this->db->query($querypermintaan)->row_array();

                $querydetil = "SELECT* FROM tb_detail_pengeluaran where kd_urusan='$kd_urusan' and kd_bidang='$kd_bidang' and kd_unit='$kd_unit' and kd_sub='$kd_sub' and tahun='$tahun' and tw='$tw' and kd_bid_skpd='$kd_bid_skpd' and kd_pengeluaran='$kd_pengeluaran'";

                $pengeluaran['uraian_pengeluaran'][$key2]['tgl_permintaan']=$hasil['tgl_permintaan'];
                $pengeluaran['uraian_pengeluaran'][$key2]['detil']=$this->db->query($querydetil)->result_array();
               
            }

        }

        // echo "<pre>"; print_r( $pengeluaran);
        // die;
    
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));
        $this->db->where($array);
        $res2 = $this->db->get('tb_skpd')->row_array();

        $this->db->where($array);
        $this->db->where('kd_jabatan','1');
        $res5 = $this->db->get('tb_penanggung_jawab')->row_array();

        $this->db->where($array);
        $this->db->where('kd_jabatan','2');
        $res6 = $this->db->get('tb_penanggung_jawab')->row_array();

        $this->db->where($array);
        $this->db->where('kd_jabatan','3');
        $res7 = $this->db->get('tb_penanggung_jawab')->row_array();
       
        
        $test = "pdf";
        $final_res = array();
        
        if ($action == 'pdf') 
        {
            $final_res['action'] = $action;
        } elseif ($action == 'excel') 
        {
            $final_res['action'] = $action;
        }


        $final_res['pengeluaran']=$pengeluaran;
        $final_res['skpd']=$res2;
        $final_res['pj1']=$res5;
        $final_res['pj2']=$res6;
        $final_res['pj3']=$res7;

        $strtw='';
        if($tw=='1')
        {
            $strtw='I';
        }
        else if($tw=='2')
        {
            $strtw='II';
        }
        else if($tw=='3')
        {
            $strtw='III';
        }
        else if($tw=='4')
        {
            $strtw='IV';
        }

        $final_res['tw']=$strtw;
         
        return $final_res;
    }
    

    public function get_Download_Penyerahan($id)
	{
        $res1 = $this->db->get('tb_belanja')->result_array();

        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));
        $this->db->where($array);
        $res2 = $this->db->get('tb_skpd')->row_array();

        $this->db->where('id', $id);  
        $permintaan=$this->db->get('tb_permintaan')->row_array();

        $tahun=$permintaan['tahun'];
        $bulan=$permintaan['bulan'];
        $kd_permintaan=$permintaan['kd_permintaan'];
        $kd_bid_skpd=$permintaan['kd_permintaan'];
        
        $this->db->where($array);
        $this->db->where('tahun',$tahun);
        $this->db->where('bulan',$bulan);
        $this->db->where('kd_permintaan',$kd_permintaan);
        $databappenyerahan= $this->db->get('tb_bap_penyerahan')->row_array();

        $this->db->where($array);
        $this->db->where('tahun',$tahun);
        $this->db->where('bulan',$bulan);
        $this->db->where('kd_permintaan',$kd_permintaan);
        $this->db->where('kd_bid_skpd',$kd_bid_skpd);
        $pengeluaran= $this->db->get('tb_pengeluaran')->row_array();

        $this->db->where($array);
        $this->db->where('tahun',$tahun);
        $this->db->where('bulan',$bulan);
        $this->db->where('kd_pengeluaran',$pengeluaran['kd_pengeluaran']);
        $this->db->where('kd_bid_skpd',$kd_bid_skpd);
        $detailpengeluaran= $this->db->get('tb_detail_pengeluaran')->result_array();
        

        $final_res = array();
        $final_res['skpd']=$res2;
        $final_res['penyerahan']= $databappenyerahan;
        $final_res['detail']= $detailpengeluaran;

        $data['list']=$final_res;
        $rand=rand(1,1000);
        $namafile='bappenyerahan'.$rand.'.pdf';
        $mpdf = new \Mpdf\Mpdf();
        $html1 = $this->load->view('beritaacara/bapenerimaan',$data,true);
        $mpdf->AddPage('P', '', '', '', '',
            20, // margin_left
            20, // margin right
            15, // margin top
            10, // margin bottom
            0, // margin header
            5); // margin footer
        $mpdf->SetHTMLFooter("<p style='font-size:0.6em; text-align:right;'><i>printedbySIPBuol</i></p>");
        $mpdf->WriteHTML($html1);
      
        $html2 = $this->load->view('beritaacara/bapenerimaanlampiran',$data,true);
        $mpdf->AddPage('P', '', '', '', '',
            15, // margin_left
            15, // margin right
            15, // margin top
            10, // margin bottom
            0, // margin header
            5); // margin footer
        $mpdf->SetHTMLFooter("<p style='font-size:0.6em; text-align:right;'><i>printedbySIPBuol</i></p>");
        $mpdf->WriteHTML($html2);
        $mpdf->Output($namafile,"I");
        exit();
    }
}

?>