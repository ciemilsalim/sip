<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengadaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_loged_in();
        $this->load->model('Pengadaan_model', 'pengadaan');
    }


    public function index()
    {
        $data['title'] = 'Pengadaan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

        $this->db->where('tahun', $this->session->userdata('tahun'));

        $this->db->where('status', "Aktif");
        $cektatw = $this->db->get('tb_managementa')->row_array();

        $data['aktif'] = $cektatw;
        $this->db->where($array);
        $data['supplier'] = $this->db->get('tb_supplier')->result_array();

        $data['belanja'] = $this->db->get('tb_belanja')->result_array();
        $data['sumber'] = $this->db->get('tb_sumber_dana')->result_array();

        $this->db->where($array);
        $this->db->where('kd_jabatan', '3');
        $data['pj'] = $this->db->get('tb_penanggung_jawab')->row_array();

        $this->form_validation->set_rules('supplier', 'Nama Supplier', 'required');
        $this->form_validation->set_rules('belanja', 'Nama Belanja', 'required');
        $this->form_validation->set_rules('uraian', 'Uraian', 'required');

        if ($this->form_validation->run() == false) {

            if (!empty($cektatw)) {
                $bulan = $cektatw['bulan'];
                $tahun = $this->session->userdata('tahun');
                $kd_urusan = $this->session->userdata('kd_urusan');
                $kd_bidang = $this->session->userdata('kd_bidang');
                $kd_unit = $this->session->userdata('kd_unit');
                $kd_sub = $this->session->userdata('kd_sub');
                $data['pengadaan'] = $this->pengadaan->getPengadaan($kd_urusan, $kd_bidang, $kd_unit, $kd_sub, $tahun, $bulan);
            }

            $data['index'] = 'ya';

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pengadaan/index', $data);
            $this->load->view('templates/footer');
        } else {
            $id_supplier = $this->input->post('supplier');
            $id_belanja = $this->input->post('belanja');
            $nip = $this->input->post('nip');
            $nama = $this->input->post('nama');
            $jabatan = $this->input->post('jabatan');
            $uraian = $this->input->post('uraian');
            $no_faktur = $this->input->post('no_faktur');
            $tgl_faktur = $this->input->post('tgl_faktur');
            $no_bap = $this->input->post('no_bap');
            $tgl_bap = $this->input->post('tgl_bap');
            $tahun = $this->session->userdata('tahun');
            $kd_urusan = $this->session->userdata('kd_urusan');
            $kd_bidang = $this->session->userdata('kd_bidang');
            $kd_unit = $this->session->userdata('kd_unit');
            $kd_sub = $this->session->userdata('kd_sub');
            $sumber = $this->input->post('sumber');


            $cek = $this->db->get('tb_pengadaan')->result_array();

            if ($cek > 0) {
                $this->db->select_max('kd_pengadaan');
                $this->db->where($array);
                $result = $this->db->get('tb_pengadaan')->row_array();
                $maxkd = $result['kd_pengadaan'];
                $maxkd++;
                $no = $maxkd++;
            } else {
                $no = '1';
            }


            $data = array(
                'kd_urusan' => $kd_urusan,
                'kd_bidang' => $kd_bidang,
                'kd_unit' => $kd_unit,
                'kd_sub' => $kd_sub,
                'tahun' => $cektatw['tahun'],
                'bulan' => $cektatw['bulan'],
                'kd_pengadaan ' => $no,
                'uraian_pembelian' => $uraian,
                // 'nomor_faktur' =>  $no_faktur,
                // 'tgl_faktur' =>  $tgl_faktur,
                // 'nomor_bap' =>  $no_bap,
                // 'tgl_bap' =>  $tgl_bap,
                'kd_belanja' =>  $id_belanja,
                'kd_supplier' =>  $id_supplier,
                'nip_penerima' =>  $nip,
                'nama_penerima' =>  $nama,
                'jabatan' =>  $jabatan,
                'kd_sumber' => $sumber,
                'status_penerimaan' => 0,
                'status_pengadaan' => 0
            );


            $this->db->insert('tb_pengadaan', $data);
            // $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');
            $this->detilpengadaan($no, $sumber);
            redirect('pengadaan/detilpengadaan/' . $no . '/' . $sumber);
        }
    }

    public function hapuspengadaan()
    {
        $id['id'] = $this->uri->segment(3);

        $this->db->where('id', $id);
        $this->db->delete('tb_pengadaan');

        echo json_encode('Y');
    }



    public function pilihanbulan()
    {
        $data['title'] = 'Pengadaan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

        $this->db->where('status', "Aktif");
        $cektatw = $this->db->get('tb_managementa')->row_array();
        $data['aktif'] = $cektatw;
        $this->db->where($array);
        $data['supplier'] = $this->db->get('tb_supplier')->result_array();

        // $this->db->where($array);
        $data['belanja'] = $this->db->get('tb_belanja')->result_array();
        $data['sumber'] = $this->db->get('tb_sumber_dana')->result_array();

        $this->db->where($array);
        $this->db->where('kd_jabatan', '3');
        $data['pj'] = $this->db->get('tb_penanggung_jawab')->row_array();

        $bulan = $this->uri->segment(3);
        $tahun = $this->session->userdata('tahun');
        $kd_urusan = $this->session->userdata('kd_urusan');
        $kd_bidang = $this->session->userdata('kd_bidang');
        $kd_unit = $this->session->userdata('kd_unit');
        $kd_sub = $this->session->userdata('kd_sub');

        $data['index'] = $bulan;

        $data['pengadaan'] = $this->pengadaan->getPengadaan($kd_urusan, $kd_bidang, $kd_unit, $kd_sub, $tahun, $bulan);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengadaan/index', $data);
        $this->load->view('templates/footer');
    }


    public function detilpengadaan()
    {
        $data['title'] = 'Pengadaan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

        $this->db->where('status', "Aktif");
        $cektatw = $this->db->get('tb_managementa')->row_array();
        $data['aktif'] = $cektatw;


        $bulan = $cektatw['bulan'];
        $tahun = $this->session->userdata('tahun');
        $kd_urusan = $this->session->userdata('kd_urusan');
        $kd_bidang = $this->session->userdata('kd_bidang');
        $kd_unit = $this->session->userdata('kd_unit');
        $kd_sub = $this->session->userdata('kd_sub');

        $kd_pengadaan = $this->uri->segment(3);
        $data['pengadaan'] = $this->pengadaan->getPengadaan2($kd_urusan, $kd_bidang, $kd_unit, $kd_sub, $tahun, $bulan, $kd_pengadaan);

        $kd_sumber = $this->uri->segment(4);
        // $query="SELECT * From tb_da_detail where kd_urusan='$kd_urusan' and kd_bidang='$kd_bidang' and kd_unit='$kd_unit' and kd_sub='$kd_sub' and tahun='$tahun' and kd_sumber='$kd_sumber' ORDER BY uraian_komponen asc";
        $query = "SELECT a.*,  (select sum(b.jumlah) from tb_penerimaan b where b.kd_urusan=a.kd_urusan and b.kd_bidang=a.kd_bidang and b.kd_unit=a.kd_unit and b.kd_jenis=a.kd_jenis and b.kd_komponen=a.kd_komponen and b.kd_uraian=a.kd_uraian and b.tahun=a.tahun and b.kd_sumber=a.kd_sumber ) as jumlahrealisasi, (select sum(b.harga_total) from tb_penerimaan b where b.kd_urusan=a.kd_urusan and b.kd_bidang=a.kd_bidang and b.kd_unit=a.kd_unit and b.kd_jenis=a.kd_jenis and b.kd_komponen=a.kd_komponen and b.kd_uraian=a.kd_uraian and b.tahun=a.tahun and b.kd_sumber=a.kd_sumber) as hargarealisasi From tb_da_detail a where kd_urusan='$kd_urusan' and kd_bidang='$kd_bidang' and kd_unit='$kd_unit' and kd_sub='$kd_sub' and tahun='$tahun' and kd_sumber='$kd_sumber' ORDER BY a.uraian_komponen asc ";
        $data['komponen'] = $this->db->query($query)->result_array();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengadaan/detilpengadaan', $data);
        $this->load->view('templates/footer');
    }

    public function detilpengadaan2()
    {
        $data['title'] = 'Pengadaan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

        $this->db->where('status', "Aktif");
        $cektatw = $this->db->get('tb_managementa')->row_array();
        $data['aktif'] = $cektatw;


        $bulan = $cektatw['bulan'];
        $tahun = $this->session->userdata('tahun');
        $kd_urusan = $this->session->userdata('kd_urusan');
        $kd_bidang = $this->session->userdata('kd_bidang');
        $kd_unit = $this->session->userdata('kd_unit');
        $kd_sub = $this->session->userdata('kd_sub');

        $id = $this->uri->segment(3);
        $data['pengadaan'] = $this->pengadaan->getPengadaan2($kd_urusan, $kd_bidang, $kd_unit, $kd_sub, $tahun, $bulan, $id);

        $kd_sumber = $this->uri->segment(4);
        $query = "SELECT * From tb_pengadaan_detail where kd_urusan='$kd_urusan' and kd_bidang='$kd_bidang' and kd_unit='$kd_unit' and kd_sub='$kd_sub' and tahun='$tahun' and kd_pengadaan='$id' and kd_sumber='$kd_sumber' ORDER BY uraian_komponen asc";
        $data['komponen'] = $this->db->query($query)->result_array();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengadaan/detailpengadaan2', $data);
        $this->load->view('templates/footer');
    }

    public function simpandetailpengadaan()
    {

        $tahun = $this->session->userdata('tahun');
        $kd_urusan = $this->session->userdata('kd_urusan');
        $kd_bidang = $this->session->userdata('kd_bidang');
        $kd_unit = $this->session->userdata('kd_unit');
        $kd_sub = $this->session->userdata('kd_sub');
        $sumberdana = $this->input->post('sumber');
        $kd_pengadaan = $this->uri->segment(3);

        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

        $datajson = json_decode($this->input->post('jsondata'), true);
        foreach ($datajson as $key => $arr) {
            if ($datajson[$key]['jumlah'] == 0) {
                continue;
            } else {
                $data = array(
                    'kd_urusan' => $kd_urusan,
                    'kd_bidang' => $kd_bidang,
                    'kd_unit' => $kd_unit,
                    'kd_sub' => $kd_sub,
                    'kd_pengadaan' => $kd_pengadaan,
                    'kd_jenis' => $datajson[$key]['kd_jenis'],
                    'kd_komponen' => $datajson[$key]['kd_komponen'],
                    'kd_uraian' => $datajson[$key]['kd_uraian'],
                    'uraian_komponen' => $datajson[$key]['uraian'],
                    'satuan' => $datajson[$key]['satuan'],
                    'harga_satuan' => $datajson[$key]['hargasatuan'],
                    'harga_da' => $datajson[$key]['hargada'],
                    'jumlah_pengadaan' => $datajson[$key]['jumlah'],
                    'harga_pengadaan' => $datajson[$key]['total'],
                    'tahun' =>  $tahun,
                    'kd_sumber' => $sumberdana,
                );
                $this->db->insert('tb_pengadaan_detail', $data);
            }
        }

        $datax = array(
            'status_pengadaan' => 1
        );

        $this->db->where($array);
        $this->db->where('kd_pengadaan', $kd_pengadaan);
        $this->db->update('tb_pengadaan', $datax);

        $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');
        redirect('pengadaan/index');
    }


    public function penerimaan()
    {
        $data['title'] = 'Pengadaan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

        $this->db->where('status', "Aktif");
        $cektatw = $this->db->get('tb_managementa')->row_array();
        $data['aktif'] = $cektatw;


        $bulan = $cektatw['bulan'];
        $tahun = $this->session->userdata('tahun');
        $kd_urusan = $this->session->userdata('kd_urusan');
        $kd_bidang = $this->session->userdata('kd_bidang');
        $kd_unit = $this->session->userdata('kd_unit');
        $kd_sub = $this->session->userdata('kd_sub');

        $id = $this->uri->segment(3);
        $data['pengadaan'] = $this->pengadaan->getPengadaan2($kd_urusan, $kd_bidang, $kd_unit, $kd_sub, $tahun, $bulan, $id);

        $kd_sumber = $this->uri->segment(4);
        $query = "SELECT * From tb_pengadaan_detail where kd_urusan='$kd_urusan' and kd_bidang='$kd_bidang' and kd_unit='$kd_unit' and kd_sub='$kd_sub' and tahun='$tahun' and kd_pengadaan='$id' and kd_sumber='$kd_sumber' ORDER BY uraian_komponen asc";
        $data['komponen'] = $this->db->query($query)->result_array();

        if ($data['pengadaan']['status_penerimaan'] == 1) {
            redirect('pengadaan/index');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pengadaan/penerimaan', $data);
            $this->load->view('templates/footer');
        }
    }


    public function penerimaanbarang()
    {
        $datajson = json_decode($this->input->post('jsondata'), true);

        $kd_pengadaan = $this->input->post('kd_pengadaan');
        $kd_sumber = $this->input->post('sumber');
        $sp2d = $this->input->post('sp2d');

        $this->db->where('status', "Aktif");
        $cektatw = $this->db->get('tb_managementa')->row_array();
        $data['aktif'] = $cektatw;

        $bulan = $cektatw['bulan'];
        $tahun = $cektatw['tahun'];
        $kd_urusan = $this->session->userdata('kd_urusan');
        $kd_bidang = $this->session->userdata('kd_bidang');
        $kd_unit = $this->session->userdata('kd_unit');
        $kd_sub = $this->session->userdata('kd_sub');

        $no_faktur = $this->input->post('no_faktur');
        $tgl_faktur = $this->input->post('tgl_faktur');
        $no_bap = $this->input->post('no_bap');
        $tgl_bap = $this->input->post('tgl_bap');


        $datax = array(
            'nomor_faktur' => $no_faktur,
            'tgl_faktur' => $tgl_faktur,
            'nomor_bap' => $no_bap,
            'tgl_bap' => $tgl_bap,
            'no_sp2d' => $sp2d,
            'status_penerimaan' => 1
        );

        $this->db->where('kd_urusan', $kd_urusan);
        $this->db->where('kd_bidang', $kd_bidang);
        $this->db->where('kd_unit', $kd_unit);
        $this->db->where('kd_sub', $kd_sub);
        $this->db->where('tahun', $tahun);
        $this->db->where('bulan', $bulan);
        $this->db->where('kd_pengadaan', $kd_pengadaan);
        $this->db->update('tb_pengadaan', $datax);

        foreach ($datajson as $key => $arr) {
            if ($datajson[$key]['jumlah'] == 0) {
                continue;
            } else {
                $data = array(
                    'kd_urusan' => $kd_urusan,
                    'kd_bidang' => $kd_bidang,
                    'kd_unit' => $kd_unit,
                    'kd_sub' => $kd_sub,
                    'kd_pengadaan' => $kd_pengadaan,
                    'kd_jenis' => $datajson[$key]['kd_jenis'],
                    'kd_komponen' => $datajson[$key]['kd_komponen'],
                    'kd_uraian' => $datajson[$key]['kd_uraian'],
                    'uraian_komponen' => $datajson[$key]['uraian'],
                    'satuan' => $datajson[$key]['satuan'],
                    'harga_satuan_da' => $datajson[$key]['hargada'],
                    'jumlah ' => $datajson[$key]['jumlah'],
                    'harga_total' =>  $datajson[$key]['total'],
                    'tahun' =>  $tahun,
                    'bulan' =>  $bulan,
                    'kd_sumber' =>  $kd_sumber,
                    'tgl_penerimaan' =>  date("Y/m/d")
                );
                $this->db->insert('tb_penerimaan', $data);
            }
        }


        $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');

        // if($this->uri->segment(3)!=null)
        // {
        //     $kd_pengadaan=$this->uri->segment(4);
        //     $this->load->model('Lampiranpenerimaan', 'lampiran');
        //     $this->lampiran->get_Download($kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$bulan,$kd_pengadaan);
        // }
        // $this->load->model('Lampiranpenerimaan', 'lampiran');
        // $this->lampiran->get_Download($kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$tahun,$bulan,$kd_pengadaan);
        redirect('Pengadaan/detilpenerimaan/' . $kd_pengadaan . '/' . $bulan);
    }


    public function lampiran()
    {
        $kd_pengadaan = $this->uri->segment(3);
        $bulan = $this->uri->segment(4);
        $tahun = $this->session->userdata('tahun');
        $kd_urusan = $this->session->userdata('kd_urusan');
        $kd_bidang = $this->session->userdata('kd_bidang');
        $kd_unit = $this->session->userdata('kd_unit');
        $kd_sub = $this->session->userdata('kd_sub');

        $this->load->model('Lampiranpenerimaan', 'lampiran');
        $this->lampiran->get_Download($kd_urusan, $kd_bidang, $kd_unit, $kd_sub, $tahun, $bulan, $kd_pengadaan);
        // die;
        redirect('pengadaan/index');
    }



    public function detilpenerimaan()
    {
        $data['title'] = 'Penerimaan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

        $this->db->where('status', "Aktif");
        $cektatw = $this->db->get('tb_managementa')->row_array();
        $data['aktif'] = $cektatw;


        $bulan = $this->uri->segment(4);
        $tahun = $this->session->userdata('tahun');
        $kd_urusan = $this->session->userdata('kd_urusan');
        $kd_bidang = $this->session->userdata('kd_bidang');
        $kd_unit = $this->session->userdata('kd_unit');
        $kd_sub = $this->session->userdata('kd_sub');

        $id = $this->uri->segment(3);
        $data['pengadaan'] = $this->pengadaan->getPengadaan2($kd_urusan, $kd_bidang, $kd_unit, $kd_sub, $tahun, $bulan, $id);


        $query = "SELECT * From tb_penerimaan where kd_urusan='$kd_urusan' and kd_bidang='$kd_bidang' and kd_unit='$kd_unit' and kd_sub='$kd_sub' and tahun='$tahun' and bulan='$bulan' and kd_pengadaan='$id' ORDER BY uraian_komponen asc";
        $data['komponen'] = $this->db->query($query)->result_array();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengadaan/detilpenerimaan', $data);
        $this->load->view('templates/footer');
    }


    public function saldo()
    {
        $data['title'] = 'Saldo';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));

        $this->db->where('tahun', $this->session->userdata('tahun'));
        $this->db->where('status', "Aktif");
        $cektatw = $this->db->get('tb_managementa')->row_array();

        if (!empty($cektatw)) {
            $data['aktif'] = $cektatw;

            // $this->db->where($array);
            // $this->db->where('tahun', $cektatw['tahun']);
            // $this->db->where('bulan', $cektatw['bulan']);

            $bulan = $cektatw['bulan'];
            $tahun = $cektatw['tahun'];
            $kd_urusan = $this->session->userdata('kd_urusan');
            $kd_bidang = $this->session->userdata('kd_bidang');
            $kd_unit = $this->session->userdata('kd_unit');
            $kd_sub = $this->session->userdata('kd_sub');

            $data['saldo'] = $this->pengadaan->getSaldo($kd_urusan, $kd_bidang, $kd_unit, $kd_sub, $tahun, $bulan);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pengadaan/saldo', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pengadaan/notactive', $data);
            $this->load->view('templates/footer');
        }
    }


    public function saldoawal()
    {
        $data['title'] = 'Saldo Awal';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'));

        $this->db->where('tahun', $this->session->userdata('tahun'));
        $this->db->where('status', "Aktif");
        $cektatw = $this->db->get('tb_managementa')->row_array();

        if (!empty($cektatw)) {
            $data['aktif'] = $cektatw;

            $this->db->select('*');
            $this->db->from('tb_saldo_awal a');
            $this->db->join('tb_sumber_dana b', 'b.kd_sumber = a.kd_sumber');
            $this->db->where($array);
            $this->db->where('a.tahun_saldo_awal', $cektatw['tahun']);
            $this->db->where('a.bulan_saldo_awal', $cektatw['bulan']);
            $this->db->order_by('b. nama_sumber');
            $this->db->order_by('a. uraian_komponen');
            $data['saldo_awal'] = $this->db->get()->result_array();

            $this->db->where($array);
            $status = $this->db->get('tb_saldo_awal_skpd_status')->row_array();
            if (count($status) > 0) {
                    if ($status['status_saldo_awal'] == 0) {
                            $data['status'] = '0';
                        } else {
                            $data['status'] = '1';
                        }
                } else {
                $data['status'] = '0';
            }

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pengadaan/saldoAwal', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pengadaan/notactive', $data);
            $this->load->view('templates/footer');
        }
    }


    public function tambahsaldoawal()
    {
        $data['title'] = 'Tambah Saldo Awal';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $tahun = $this->session->userdata('tahun');
        $kd_urusan = $this->session->userdata('kd_urusan');
        $kd_bidang = $this->session->userdata('kd_bidang');
        $kd_unit = $this->session->userdata('kd_unit');
        $kd_sub = $this->session->userdata('kd_sub');

        // $this->db->where("tb_sumber_dana.kd_sumber NOT IN (select kd_sumber from tb_da where kd_urusan='$kd_urusan' and kd_bidang='$kd_bidang' and kd_unit='$kd_unit' and kd_sub='$kd_sub' and tahun='$tahun' )",NULL,FALSE);
        $data['sumber'] = $this->db->get('tb_sumber_dana')->result_array();


        $this->db->where('tahun', $this->session->userdata('tahun'));
        $this->db->where('status', "Aktif");
        $data['aktif'] = $this->db->get('tb_managementa')->row_array();


        $data['komponen'] = $this->db->get('tb_uraian_komponen')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengadaan/tambahsaldoawal', $data);
        $this->load->view('templates/footer');
    }


    public function simpansaldoawal()
    {
        $sumberdana = $this->input->post('sumber');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        $array = array('kd_urusan' => $this->session->userdata('kd_urusan'), 'kd_bidang' => $this->session->userdata('kd_bidang'), 'kd_unit' => $this->session->userdata('kd_unit'), 'kd_sub' => $this->session->userdata('kd_sub'), 'tahun' => $this->session->userdata('tahun'));
        $kd_urusan = $this->session->userdata('kd_urusan');
        $kd_bidang = $this->session->userdata('kd_bidang');
        $kd_unit = $this->session->userdata('kd_unit');
        $kd_sub = $this->session->userdata('kd_sub');


        $datajson = json_decode($this->input->post('jsondata'), true);
        foreach ($datajson as $key => $arr) {
            if ($datajson[$key]['jumlah'] == 0) {
                continue;
            } else {
                $data = array(
                    'kd_urusan' => $kd_urusan,
                    'kd_bidang' => $kd_bidang,
                    'kd_unit' => $kd_unit,
                    'kd_sub' => $kd_sub,
                    // 'kd_da' => $no,
                    'kd_jenis' => $datajson[$key]['kd_jenis'],
                    'kd_komponen' => $datajson[$key]['kd_komponen'],
                    'kd_uraian' => $datajson[$key]['kd_uraian'],
                    'uraian_komponen' => $datajson[$key]['uraian'],
                    'satuan' => $datajson[$key]['satuan'],
                    'tahun_pengadaan' => '0',
                    'kd_pengadaan' => '0',
                    'harga_satuan_da' => $datajson[$key]['hargainput'],
                    'jumlah' => $datajson[$key]['jumlah'],
                    'harga_total' => $datajson[$key]['total'],
                    'harga_koreksi' => $datajson[$key]['hargainput'],
                    'jumlah_koreksi' => $datajson[$key]['jumlah'],
                    'harga_total_koreksi' =>  $datajson[$key]['total'],
                    'tahun_saldo_awal' =>  $tahun,
                    'bulan_saldo_awal' =>  $bulan,
                    'kd_sumber' => $sumberdana,
                    'tahun_sebelumnya' =>  '0',
                    'bulan_sebelumnya' =>  '0'
                );
                $this->db->insert('tb_saldo_awal', $data);
            }
        }

        $this->session->set_flashdata('message', '<div class = "alert alert-success" role="alert">Data berhasil disimpan</div>');
        redirect('pengadaan/saldoAwal');
    }
}
