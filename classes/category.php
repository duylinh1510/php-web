<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');
 ?>
 
 <?php
    class category {
        private $db;
        private $fm;

        public function __construct() {
            $this->db =new Database();
            $this->fm =new Format();
        }

        // ================================================
        //            Insert danh mục trong admin
        // ================================================        
        public function insert_category($catName) {
            $catName = $this->fm->validation($catName);
            $catName = mysqli_real_escape_string($this->db->link, $catName);
        
            if(empty($catName)) {
                $alert = "<span class='error'>Tên danh mục không được để trống</span>";
                return $alert;
            } else {
                // Kiểm tra xem danh mục đã tồn tại chưa
                $query_check = "SELECT * FROM tbl_category WHERE catName = '$catName'";
                $result_check = $this->db->select($query_check);
                if ($result_check) {
                    $alert = "<span class='error'>Danh mục này đã tồn tại. Vui lòng chọn tên khác.</span>";
                    return $alert;
                }
        
                // Nếu không có trùng lặp, thực hiện thêm mới
                $query = "INSERT INTO tbl_category(catName) VALUES('$catName')";
                $result = $this->db->insert($query);
                if ($result) {
                    $alert = "<span class='success'>Thêm danh mục thành công</span>";
                    return $alert;
                } else {
                    $alert = "<span class='error'>Thêm danh mục không thành công</span>";
                    return $alert;
                }
            }
        }
        

        // ================================================
        //            Update danh mục trong admin
        // ================================================
        public function update_category($catName,$id) {
            $catName = $this->fm->validation($catName);
            $catName = mysqli_real_escape_string($this->db->link, $catName);
            $id = mysqli_real_escape_string($this->db->link, $id);

            if(empty($catName)) {
                $alert = "<span class='error'>Tên danh mục không được để trống</span>";
                return $alert;
            } else {
                $query = "UPDATE tbl_category SET catName = '$catName' WHERE catId = '$id'";
                $result =$this->db->insert($query);
                if($result){
                    $alert = "<span class='success'>Sửa danh mục thành công</span>";
                    return $alert;
                } else {
                    $alert = "<span class='error'>Sửa danh mục không thành công</span>";
                    return $alert;
                }
            }
        }

        // ================================================
        //            Delete danh mục trong admin
        // ================================================
        public function del_category($id){
            $query = "DELETE FROM tbl_category WHERE catId = '$id'";
            $result =$this->db->delete($query);
            if($result) {
                $alert = "<span class='success'>Xóa danh mục thành công</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Xóa danh mục không thành công</span>";
                return $alert;
            } 
        }

        // ================================================
        //              Hiện list danh mục
        // ================================================
        public function show_category() {
            $query = "SELECT * FROM tbl_category ORDER BY catName ASC";
            $result =$this->db->select($query);
            return $result;
        }

        // ================================================
        //            Lấy danh mục theo Id
        // ================================================
        public function getcatbyId($id) {
            $query = "SELECT * FROM tbl_category WHERE catId = '$id' LIMIT 1";
            $result =$this->db->select($query);
            return $result;
        }

    }
 ?>