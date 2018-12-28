<?php
class ModelCostsCost extends Model {
	public function addCost($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "cost SET description = '" . $this->db->escape((string)$data['cost_description'])."', value = '" .$this->db->escape((string)$data['cost_value'])."'");
		$cost_id = $this->db->getLastId();
		return $cost_id;
	}
	public function editCost($cost_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "cost SET  description = '" . $this->db->escape((string)$data['cost_description']) . "', value = '" . $this->db->escape((string)$data['cost_value']). "' WHERE cost_id = '" . (int)$cost_id . "'");
	}
	public function deleteCost($cost_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "cost WHERE cost_id = '" . (int)$cost_id . "'");
	}
	public function getCosts($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "cost";
		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '%" . $this->db->escape((string)$data['filter_name']) . "%'";
		}
		$sql .= " GROUP BY cost_id";
		$sort_data = array(
			'description',
			'value'
		);
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY value";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getTotalCosts() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "cost");
		return $query->row['total'];
	}
	public function getCost($costId) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cost WHERE cost_id = '" . (int)$costId . "'");
		return $query->row;
	}
}
?>