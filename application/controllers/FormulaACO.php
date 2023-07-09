<?php
defined('BASEPATH') or exit('No direct script access allowed');
include 'Aco.php';
class FormulaACO extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		if ($this->session->userdata("level") > 2) {
			redirect(base_url("Dashboard"));
		}
		$this->load->library('upload');
		$this->load->model('Model_Alternatif', 'alternatif');
		$this->load->model('Model_ObjekWisata', 'objekwisata');
		date_default_timezone_set('Asia/Jakarta');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	//kriteria	
	public function tampil()
	{

		$this->session->set_userdata("judul", "Data Kriteria");
		$ba = [
			'judul' => "Data Kriteria",
			'subjudul' => "Kelas",
		];
		
		$alternatif = $this->alternatif->get_alternatif();
		$jarak = array();
		// Mapping functionality
		$cityNames = [];
		// $cityCoor = [];
		foreach ($alternatif as $alt) {
			$cityNames['nama'] = $alt->alt_nama;
			$cityNames['latitude'] = $alt->alt_latitude;
			$cityNames['longitude'] = $alt->alt_longitude;
		}
		$data = [
			'jarak' => $jarak,
			'alternatif' => $alternatif,

			'cityNames' => $cityNames,
			'alternatif' => $alternatif
		];
		//  echo "Best tour: " . implode(" -> ", $bestTour) . PHP_EOL;
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('formula_aco', $data);
		$this->load->view('background_bawah');
		// exit();

	}

	public function calculateACO()
	{
		// starting time
		$time_start = microtime(true);
		$jumlah_alternatif = $this->alternatif->count_all();
		$jarak_peta = $this->input->post('jarak');
		$kelurahan = $this->input->post('kelurahan');
		$alternatif = $this->alternatif->kordinat_alternatif_kelurahan($kelurahan);

		for ($i = 0; $i < count($alternatif); $i++) {
			$jarak[$i] = [];
			// echo $alternatif[$i]->alt_id;
			$this->alternatif->update("smp_alternatif", array('alt_id' => $alternatif[$i]->alt_id), array("alt_jarak" => $jarak_peta[$i]));
			for ($j = 0; $j < $jumlah_alternatif; $j++) {
				if ($i == $j) {
					$jarak[$i][$j] = 0;
				} else {
					$jarak[$i][$j] = abs($jarak_peta[$j] - $jarak_peta[$i]);
				}
			}
		}


		$invers_matriks = array();
		$invers = 0;
		//    inisialisasi array lokasi

		for ($i = 0; $i < count($jarak); $i++) {
			//  $jarak[$i] = [];

			for ($j = 0; $j < count($jarak); $j++) {

				if ($jarak[$i][$j] != 0) {
					$invers = round(1 / $jarak[$i][$j], 4);
				} else {
					$invers = round($jarak[$i][$j], 4);
				}
				$invers_matriks[$i][$j] = $invers;
			}
		}

		// $pheromone = $this->initializePheromoneMatrix(count($jarak));
		$aco = new AntColonyOptimization($jarak);
		$bestTour = $aco->run();
		$cityNames = array();
		foreach ($alternatif as $alt) {
			array_push($cityNames, array("nama" => $alt->alt_nama, "latitude" => $alt->alt_latitude, "longitude" => $alt->alt_longitude, "jarak" => $alt->alt_jarak));
		}

		// Define the criteria and alternatives
		$criteria = [];
		$alternatives = [];
		$jarak_alt = [];
		$fasilitas = [];
		$kondisi = [];
		foreach ($alternatif as $alt) {
			$alternatives[] = $alt->alt_nama;
			$jarak_alt[] = $alt->alt_jarak;
			$fasilitas[] = $alt->alt_fasilitas;
			$kondisi[] = $alt->alt_kondisi;
			$latitude[] = $alt->alt_latitude;
			$longitude[] = $alt->alt_longitude;
		}
		$criteria = ['Jarak', 'Kondisi', 'Fasilitas'];

		// Define the pairwise comparison matrix for each criterion

		$jarakMatrix = [
			[1, 1 / 3, 1 / 2],
			[3, 1, 2],
			[2, 1 / 3, 1],
		];

		// Biarkan aja
		// $fasilitasMatrix = [
		// 	[1, 1/3, 1/2],
		// 	[3, 1, 2],
		// 	[1 / 3, 3, 1],
		// ];

		// $kondisiMatrix = [		
		// 	[1, 1 / 3, 1],
		// 	[1/3, 1, 1],
		// 	[1, 1 / 3, 1],
		// ];

		// Calculate the weight for each criterion
		// $weights = $this->calculateWeights([$jarakMatrix, $fasilitasMatrix, $kondisiMatrix]);
		$weights = $this->calculateWeights([$jarakMatrix]);
		// Calculate the weighted score for each alternative
		$scores = $this->calculateScores($alternatives, $criteria, $jarak_alt, $fasilitas, $kondisi, $weights, $latitude, $longitude);
		// var_dump($scores);
		// exit();
		// ending time
		$time_end = time();

		// Time difference
		$duration = $time_end - $time_start;
		$data['alternatif_selected'] = $alternatif;
		$data['cities'] = $cityNames;
		$data['bestTour'] = $bestTour;
		$data['invers_matriks'] = $invers_matriks;
		$data['scores'] = $scores;
		$data['jarak'] = $jarak;
		$data['time'] = $duration;
		echo json_encode($data);
	}

	function calculateWeights(array $matrices)
	{
		$numCriteria = count($matrices);
		$numAlternatives = count($matrices[0]);

		// Calculate the normalized matrix for each criterion
		$normalizedMatrices = [];
		foreach ($matrices as $matrix) {
			$normalizedMatrix = [];
			for ($i = 0; $i < $numAlternatives; $i++) {
				$rowSum = array_sum($matrix[$i]);
				$normalizedRow = array_map(function ($value) use ($rowSum) {
					return $value / $rowSum;
				}, $matrix[$i]);
				$normalizedMatrix[] = $normalizedRow;
			}
			$normalizedMatrices[] = $normalizedMatrix;
		}

		// Calculate the average matrix
		$averageMatrix = [];
		for ($i = 0; $i < $numAlternatives; $i++) {
			$averageRow = [];
			for ($j = 0; $j < $numAlternatives; $j++) {
				$sum = 0;
				for ($k = 0; $k < $numCriteria; $k++) {
					$sum += $normalizedMatrices[$k][$i][$j];
				}
				$averageRow[] = $sum / $numCriteria;
			}
			$averageMatrix[] = $averageRow;
		}

		// Calculate the weights
		$weights = [];
		for ($i = 0; $i < $numAlternatives; $i++) {
			$weights[] = array_sum($averageMatrix[$i]) / $numAlternatives;
		}

		// Normalize the weights
		$sumWeights = array_sum($weights);
		$weights = array_map(function ($value) use ($sumWeights) {
			return $value / $sumWeights;
		}, $weights);

		return $weights;
	}

	/**
	 * Calculates the weighted scores for each alternative based on the criteria weights.
	 *
	 * @param array $alternatives Array of alternative names
	 * @param array $criteria Array of criteria names
	 * @param array $weights Array of weights for each criterion
	 * @return array Array of weighted scores for each alternative
	 */
	function calculateScores(array $alternatives, array $criteria, array $jarak, array $fasilitas, array $kondisi,  array $weights,  array $latitude, array $longitude)
	{
		$numAlternatives = count($alternatives);
		$numCriteria = count($criteria);

		$scores = [];
		$latitudes = [];
		$longitudes = [];
		$alt_fasilitas = [];
		$alt_kondisi = [];
		for ($i = 0; $i < $numAlternatives; $i++) {
			$score = 0;
			for ($j = 0; $j < $numCriteria; $j++) {

				// Assume the scores for each criterion are pre-defined
				$criterionScore = $this->getCriterionScore($alternatives[$i], $jarak[$i], $fasilitas[$i], $kondisi[$i], $criteria[$j], $latitude[$i], $longitude[$i]);
				$score += $weights[$j] * $criterionScore;
			}

			// $scores = [
			// 	"alternatives" => $alternatives[$i],
			// 	"scores" => $score,
			// 	"latitude" => $latitude[$i],
			// 	"longitude" => $longitude[$i]
			// ];
			$scores[$alternatives[$i]] = $score;
			$latitudes[$alternatives[$i]] = $latitude[$i];
			$longitudes[$alternatives[$i]] = $longitude[$i];
			$alt_fasilitas[$alternatives[$i]] = $fasilitas[$i];
			$alt_kondisi[$alternatives[$i]] = $kondisi[$i];
		}

		return array($scores, $latitudes, $longitudes, $alt_fasilitas, $alt_kondisi);
	}

	function getCriterionScore($alternative, $jarak, $fasilitas, $kondisi, $criterion)
	{
		// Implement your own scoring mechanism based on the alternative and criterion
		// For example, you might have a database query to retrieve the scores for each alternative and criterion
		// Here, we return dummy scores for demonstration purposes


		$dummyScores = [
			$alternative => [
				'Jarak' => $jarak,
				'Kondisi' => $kondisi,
				'Fasilitas' => $fasilitas,
			],

			// Contoh pemilihan kriteria
			// 'Jl. Patria Sari' => [
			// 	'Jarak' => 1,
			// 	'Kondisi' => 2,
			// 	'Fasilitas' => 2,
			// ],
			// 'Product B' => [
			// 	'Price' => 6,
			// 	'Quality' => 9,
			// 	'Delivery' => 8,
			// ],
			// 'Product C' => [
			// 	'Price' => 7,
			// 	'Quality' => 8,
			// 	'Delivery' => 9,
			// ],
		];

		return $dummyScores[$alternative][$criterion];
	}


	public function getMyLocation()
	{
		$lat = $this->input->post('latitude');
		$long = $this->input->post('longitude');
		// Bing Maps API credentials
		// $api_key = 'ApcXBKlN_q_gUCdAPx54Q6TJIPas_388n869bziBh0wIXZ650y4yL63uw1dikV2u';

		// Koordinat statis
		// $current_lat = 0.4822993976645123;
		// $current_lng = 101.4185790413781;

		// Bing Maps API endpoint
		$api_url = "http://dev.virtualearth.net/REST/v1/Locations/{$lat},{$long}";

		// Build the request URL
		$request_url = $api_url . "?key=ApcXBKlN_q_gUCdAPx54Q6TJIPas_388n869bziBh0wIXZ650y4yL63uw1dikV2u";

		// Send the request and get the response
		$response = file_get_contents($request_url);

		// Parse the JSON response
		$data = json_decode($response, true);

		// Extract the location information
		$address = $data['resourceSets'][0]['resources'][0]['address']['formattedAddress'];
		echo json_encode($address);
		// echo "Current Location: " . $address;
	}

	public function getCoordinates()
	{
		$lokasi = $this->input->post('lokasi');
		$extract = explode("-", $lokasi);
		$data = [

			'result' => $this->objekwisata->kordinat_objekwisata($extract[0]),
			'kelurahan' => $extract[1]
		];
		// var_dump($data);
		//  exit();
		echo json_encode($data);
	}

	public function getCoordinatesAlternatif()
	{
		$lokasi = $this->input->post('lokasi');
		$data = $this->alternatif->kordinat_alternatif($lokasi);
		echo json_encode($data);
	}

	public function getRoutesByRegion()
	{
		$lokasi = $this->input->post('kelurahan');
		$data = $this->alternatif->kordinat_alternatif_kelurahan_final($lokasi);
		echo json_encode($data);
	}

	public function getDestinationDetail()
	{
		$lokasi = $this->input->post('lokasi');
		$data = $this->objekwisata->kordinat_objekwisata($lokasi);
		echo json_encode($data);
	}


	public function autoSearch()
	{
		$data = $this->objekwisata->get_objekwisata();
		$arr = [];
		foreach ($data as $d) {
			$arr[] = $d->objWis_nama . '-' . $d->objWis_kelurahan;
		}
		echo json_encode($arr);
	}


	function auto_decimal_format($n, $def = 2)
	{
		$a = explode(".", $n);
		if (count($a) > 1) {
			$b = str_split($a[1]);
			$pos = 1;
			foreach ($b as $value) {
				if ($value != 0 && $pos >= $def) {
					$c = number_format($n, $pos);
					$c_len = strlen(substr(strrchr($c, "."), 1));
					if ($c_len > $def) {
						return rtrim($c, 0);
					}
					return $c; // or break
				}
				$pos++;
			}
		}
		return number_format($n, $def);
	}
}
