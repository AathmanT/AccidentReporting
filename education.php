<?php 
	
	class education	{
		private $id;
		private $name;
		private $address;
		private $type;
		private $lat;
		private $lng;
		private $conn;
		private $tableName = "colleges";

		function setId($id) { $this->id = $id; }
		function getId() { return $this->id; }
		function setName($name) { $this->name = $name; }
		function getName() { return $this->name; }
		function setAddress($address) { $this->address = $address; }
		function getAddress() { return $this->address; }
		function setType($type) { $this->type = $type; }
		function getType() { return $this->type; }
		function setLat($lat) { $this->lat = $lat; }
		function getLat() { return $this->lat; }
		function setLng($lng) { $this->lng = $lng; }
		function getLng() { return $this->lng; }

		public function __construct() {
			require_once('db/DbConnect.php');
			$conn = new DbConnect;
			$this->conn = $conn->connect();
		}

		public function getCollegesBlankLatLng() {
			$sql = "SELECT * FROM $this->tableName WHERE lat IS NULL AND lng IS NULL";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getAllColleges() {
			$sql = "SELECT * FROM reports where pending=1";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		public function display()
        {
            $mysqli = new mysqli('localhost', 'root', '', 'accidentreporter');
            if ($mysqli->connect_errno) {
                echo "Failed to connect to MySQL: " . $mysqli->connect_error;
                exit();
            }
            $output="";
            if ($results = $mysqli->query("select * from reports where pending=1")) {

                if ($results->num_rows) {

                    while ($row = $results->fetch_object()) {
                        $output .= '<li class="list-group-item nopadding">
                <div class="card w-100">
                    <div class="row no-gutters">
                        <div class="col-8">
                            <div class="card-body">
                                <h5 class="card-title">'.$row->nameOfPlace.'</h5>
                                <p class="card-text">'.$row->Description.'</p>
                                <p class="card-text">
                                    <small class="text-muted">'.$row->LicenseNo.' - '.$row->time.'</small>
                                </p>
                                <a href="accept.php?id='.$row->ID.'" class="btn btn-success">Accept</a>
                                <a href="reject.php?id='.$row->ID.'" class="btn btn-danger">Reject</a>
                            </div>
                        </div>
                        <div class="col-4">
                            <img src="data:image;base64,' . $row->image . '" class="card-img" alt="...">
                        </div>
                    </div>
                </div>
            </li>';
                    }
                    $results->free();

                }

            } else {
                echo("Error description: " . $mysqli->error);
            }
            $mysqli->close();
            return $output;
        }

		public function updateCollegesWithLatLng() {
			$sql = "UPDATE $this->tableName SET lat = :lat, lng = :lng WHERE id = :id";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':lat', $this->lat);
			$stmt->bindParam(':lng', $this->lng);
			$stmt->bindParam(':id', $this->id);

			if($stmt->execute()) {
				return true;
			} else {
				return false;
			}
		}
	}

?>