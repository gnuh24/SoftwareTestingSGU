<?php 
    require_once __DIR__ . "/../../Configure/MysqlConfig.php";

    if (isset($_GET['isDemoHome'])) {

        $result = getAllSanPham(1, "", null, null, null, null, null, null, 1, null);
    
        echo json_encode($result);

    } 
    else if (isset($_GET['isProductPage'])) {
        // Kiểm tra và gán giá trị cho $page từ $_GET
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
    
        // Kiểm tra và gán giá trị cho $search từ $_GET
        $search = isset($_GET['search']) ? $_GET['search'] : "";
    
        // Kiểm tra và gán giá trị cho $minTheTich từ $_GET
        $minTheTich = isset($_GET['minTheTich']) ? $_GET['minTheTich'] : null;
    
        // Kiểm tra và gán giá trị cho $maxTheTich từ $_GET
        $maxTheTich = isset($_GET['maxTheTich']) ? $_GET['maxTheTich'] : null;
    
        // Kiểm tra và gán giá trị cho $minGia từ $_GET
        $minGia = isset($_GET['minGia']) ? $_GET['minGia'] : null;
    
        // Kiểm tra và gán giá trị cho $maxGia từ $_GET
        $maxGia = isset($_GET['maxGia']) ? $_GET['maxGia'] : null;
    
        // Kiểm tra và gán giá trị cho $minNongDoCon từ $_GET
        $minNongDoCon = isset($_GET['minNongDoCon']) ? $_GET['minNongDoCon'] : null;
    
        // Kiểm tra và gán giá trị cho $maxNongDoCon từ $_GET
        $maxNongDoCon = isset($_GET['maxNongDoCon']) ? $_GET['maxNongDoCon'] : null;
    
        // Kiểm tra và gán giá trị cho $maLoaiSanPham từ $_GET
        $maLoaiSanPham = $_GET['maLoaiSanPham'] !== '0' ? $_GET['maLoaiSanPham'] : null;

    
        $result = getAllSanPham($page, $search, $minTheTich, $maxTheTich, $minGia, $maxGia, $minNongDoCon, $maxNongDoCon, 1, $maLoaiSanPham);
    
        echo json_encode($result);
    } 
    
    else if (isset($_GET['getManager'])){
            // Kiểm tra và gán giá trị cho $page từ $_GET
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
        
            // Kiểm tra và gán giá trị cho $search từ $_GET
            $search = isset($_GET['search']) ? $_GET['search'] : "";
        
            // Kiểm tra và gán giá trị cho $minGia từ $_GET
            $minGia = isset($_GET['minGia']) ? $_GET['minGia'] : null;
        
            // Kiểm tra và gán giá trị cho $maxGia từ $_GET
            $maxGia = isset($_GET['maxGia']) ? $_GET['maxGia'] : null;
            
            // Kiểm tra và gán giá trị cho $maLoaiSanPham từ $_GET
            $maLoaiSanPham = $_GET['maLoaiSanPham'] !== '0' ? $_GET['maLoaiSanPham'] : null;

            // Kiểm tra và gán giá trị cho $trangThai từ $_GET
            $trangThai =  $_GET['trangThai'] != ""  ? $_GET['trangThai'] : null;

        
            $result = getAllSanPham($page, $search, null, null, $minGia, $maxGia, null, null, $trangThai, $maLoaiSanPham);
        
            echo json_encode($result);
    }

    else if (isset($_POST["changeState"])){
        $maSanPham = $_POST["maSanPham"];
        $trangThai = $_POST["trangThai"];

        $result = updateTrangThaiSanPham($maSanPham, $trangThai);

        echo json_encode($result);
    }
    
    else if(isset($_GET['search'])){
        $search = $_GET['search'];
        $result = getAllSanPhamnotpagination($search);
        echo json_encode($result);
    } else if (isset($_POST['action'])){
        if ($_POST['action'] == "up"){
            $maSanPham = $_POST['maSanPham'];
            $soLuongTang = $_POST['soLuongTang'];
            $result = tangSoLuongSanPham($maSanPham, $soLuongTang);
            echo json_encode($result);
        }
        if ($_POST['action'] == "down"){
            $maSanPham = $_POST['maSanPham'];
            $soLuongGiam = $_POST['soLuongGiam'];
            $result = giamSoLuongSanPham($maSanPham, $soLuongGiam);
            echo json_encode($result);
        }

        if ($_POST['action'] == "create"){
            $tenSanPham = $_POST['tenSanPham'];
            $maLoaiSanPham = $_POST['maLoaiSanPham'];
            $xuatXu = $_POST['xuatXu'];
            $thuongHieu = $_POST['thuongHieu'];
            $theTich = $_POST['theTich'];
            $nongDoCon = $_POST['nongDoCon'];
            $gia = $_POST['gia'];
            $anhMinhHoa = $_POST['anhMinhHoa'];
        
            // Tiếp tục xử lý các giá trị khác ở đây
            $result = createSanPham($tenSanPham, $xuatXu, $thuongHieu, $gia, $theTich, $nongDoCon, $anhMinhHoa, $maLoaiSanPham);
            echo json_encode($result);
        }

        if ($_POST['action'] == "update"){
            $maSanPham = $_POST['maSanPham'];
            $tenSanPham = $_POST['tenSanPham'];
            $maLoaiSanPham = $_POST['maLoaiSanPham'];
            $xuatXu = $_POST['xuatXu'];
            $thuongHieu = $_POST['thuongHieu'];
            $theTich = $_POST['theTich'];
            $nongDoCon = $_POST['nongDoCon'];
            $gia = $_POST['gia'];
            $trangThai = $_POST['trangThai'];
            $soLuongConLai = $_POST['soLuongConLai'];
            $anhMinhHoa = $_POST['anhMinhHoa'];
        
            // Tiếp tục xử lý các giá trị khác ở đây
            $result = updateSanPham($maSanPham, $tenSanPham, $xuatXu, $thuongHieu, $theTich, $nongDoCon, $gia, $soLuongConLai, $anhMinhHoa, $trangThai, $maLoaiSanPham);
            echo json_encode($result);
        }
    } else if (isset($_GET['MaSanPham'])){
        $maSanPham = $_GET['MaSanPham'];
        $result = getSanPhamByMaSanPham($maSanPham);
        echo json_encode($result);
    } else if (isset($_GET['checkExists'])){
        $tenSanPham = $_GET["tenSanPham"];
        $result = isTenSanPhamExists($tenSanPham);
        echo json_encode($result);
    } else if (isset($_GET['checkBelong'])){
        $maSanPham = $_GET["maSanPham"];
        $tenSanPham = $_GET["tenSanPham"];
        $result = isTenSanPhamBelongToMaSanPham($maSanPham, $tenSanPham);
        echo json_encode($result);
    } 

   

    function getAllSanPhamnotpagination($search = null){
        
        // Chuẩn bị trước biến $connection
        $connection = null;

        // Chuẩn bị câu truy vấn gốc
        $query = "SELECT * FROM `SanPham`";


        if (isset($search) & $search !="") {
            $where_conditions[] = "`TenSanPham` like '%$search%'";
        }
        if (!empty($where_conditions)) {
            $query .= " WHERE " . implode(" AND ", $where_conditions);
        }  

        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();
        

            // Query dùng để tính tổng số trang của các data trả về
            $query_total_row = "SELECT COUNT(*) FROM `SanPham`";
            $statement_total_row = $connection->prepare($query_total_row);
            $statement_total_row->execute();


        try {
            $statement = $connection->prepare($query);

            if ($statement !== false) {
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                return (object) [
                    "status" => 200,
                    "message" => "Thành công",
                    "data" => $result,
                ];
            } else {
                throw new PDOException();
            }
        } catch (PDOException $e) {
            return (object) [
                "status" => 400,
                "message" => "Lỗi không thể lấy danh sách sản phẩm",
            ];
        } finally {
            $connection = null;
        }
    }

    function getAllSanPham($page, $search, $minTheTich, $maxTheTich, $minGia, $maxGia, $minNongDo, $maxNongDo, $trangThai, $maLoaiSanPham) {
        // Chuẩn bị trước biến $connection
        $connection = null;
    
        // Chuẩn bị câu truy vấn gốc
        $query = "SELECT * FROM `SanPham` JOIN `LoaiSanPham` ON `SanPham`.`MaLoaiSanPham` = `LoaiSanPham`.`MaLoaiSanPham`";
    
        // Mảng chứa điều kiện
        $where_conditions = [];
    
        // Số phần tử mỗi trang
        $entityPerPage = 12;
    
        // Tổng số trang
        $totalPages = null;
    
        // Lọc theo search
        if (!empty($search)) {
            $where_conditions[] = "`TenSanPham` LIKE '%" . $search . "%'";
        }
    
        // Lọc theo khoảng giá
        if (isset($minGia) && isset($maxGia)) {
            $where_conditions[] = "`Gia` BETWEEN $minGia AND $maxGia";
        }
    
        // Lọc theo khoảng thể tích
        if (isset($minTheTich) && isset($maxTheTich)) {
            $where_conditions[] = "`TheTich` BETWEEN $minTheTich AND $maxTheTich";
        }
    
        // Lọc theo khoảng nồng độ
        if (isset($minNongDo) && isset($maxNongDo)) {
            $where_conditions[] = "`NongDoCon` BETWEEN $minNongDo AND $maxNongDo";
        }
    
        // Lọc theo trạng thái
        if (isset($trangThai)) {
            $where_conditions[] = "`TrangThai` = $trangThai";
        }
    
        // Lọc theo loại sản phẩm
        if (isset($maLoaiSanPham)) {
            $where_conditions[] = "`SanPham`.`MaLoaiSanPham` = $maLoaiSanPham";
        }
    
        // Kết nối các điều kiện lại với nhau (Nếu không có thì skip)
        if (!empty($where_conditions)) {
            $query .= " WHERE " . implode(" AND ", $where_conditions);
        }
    
        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();
    
        // Tính toán tổng số trang
        if ($totalPages === null) {
            // Query dùng để tính tổng số trang của các data trả về
            $query_total_row = substr_replace($query, "COUNT(*)", 7, 1);
            $statement_total_row = $connection->prepare($query_total_row);
            $statement_total_row->execute();
    
            // Làm tròn lên -> Tính ra tổng số trang
            $totalPages = ceil($statement_total_row->fetchColumn() / $entityPerPage);
        }
    
        // Kiểm tra tham số phân trang
        $current_page = isset($page) ? $page : 1;
        $start_from = ($current_page - 1) * $entityPerPage;
    
        $query .= " LIMIT $entityPerPage OFFSET $start_from";
    
        try {
            $statement = $connection->prepare($query);
    
            if ($statement !== false) {
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
                return (object) [
                    "status" => 200,
                    "message" => "Thành công",
                    "data" => $result,
                    "totalPages" => $totalPages
                ];
            } else {
                throw new PDOException();
            }
        } catch (PDOException $e) {
            return (object) [
                "status" => 400,
                "message" => $e->getMessage(),
            ];
        } finally {
            $connection = null;
        }
    }
    

    function tangSoLuongSanPham($maSanPham, $soLuongTang){
        // Khởi tạo kết nối
        $connection = null;
    
        // Chuẩn bị câu truy vấn
        $query = "UPDATE `SanPham` SET `SoLuongConLai` = `SoLuongConLai` + :soLuongTang WHERE `MaSanPham` = :maSanPham";
    
        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();
    
        try {
            $statement = $connection->prepare($query);
    
            if ($statement !== false) {
                $statement->bindValue(':soLuongTang', $soLuongTang, PDO::PARAM_INT);
                $statement->bindValue(':maSanPham', $maSanPham, PDO::PARAM_INT);
    
                $statement->execute();
    
                return (object) [
                    "status" => 200,
                    "message" => "Tăng số lượng sản phẩm thành công!"
                ];
            } else {
                throw new PDOException();
            }
        } catch (PDOException $e) {
            return (object) [
                "status" => 400,
                "message" => "Lỗi không thể tăng số lượng sản phẩm"
            ];
        } finally {
            $connection = null;
        }
    }
    


    function getSanPhamByMaSanPham($maSanPham) {
        // Khởi tạo kết nối
        $connection = null;
    
        // Chuẩn bị câu truy vấn gốc
        $query = "SELECT * FROM `SanPham` WHERE `MaSanPham` = :maSanPham";
    
        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();
    
        try {
            $statement = $connection->prepare($query);
    
            if ($statement !== false) {
                $statement->bindValue(':maSanPham', $maSanPham, PDO::PARAM_INT);

    
                $statement->execute();
    
                $result = $statement->fetch(PDO::FETCH_ASSOC);
    
                return (object) [
                    "status" => 200,
                    "message" => "Truy vấn thành công!",
                    "data" => $result
                ];
            } else {
                throw new PDOException();
            }
        } catch (PDOException $e) {
            return (object) [
                "status" => 400,
                "message" => "Lỗi không thể lấy thông tin sản phẩm",
            ];
        } finally {
            $connection = null;
        }
    }
    

    function isTenSanPhamExists($tenSanPham) {
        // Khởi tạo kết nối
        $connection = null;
    
        // Chuẩn bị câu truy vấn gốc
        $query = "SELECT * FROM `SanPham` WHERE `TenSanPham` = :tenSanPham";
    
        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();
    
        try {
            $statement = $connection->prepare($query);
    
            if ($statement !== false) {
                $statement->bindValue(':tenSanPham', $tenSanPham, PDO::PARAM_STR);
    
                $statement->execute();
    
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
                $isExists = !empty($result) ? 1 : 0;
    
                return (object) [
                    "status" => 200,
                    "message" => "Truy vấn thành công!",
                    "isExists" => $isExists
                ];
            } else {
                throw new PDOException();
            }
        } catch (PDOException $e) {
            return (object) [
                "status" => 400,
                "message" => "Lỗi không thể kiểm tra sản phẩm",
            ];
        } finally {
            $connection = null;
        }
    }

    function isTenSanPhamBelongToMaSanPham($maSanPham, $tenSanPham) {
        // Khởi tạo kết nối
        $connection = null;
    
        // Chuẩn bị câu truy vấn gốc
        $query = "SELECT * FROM `SanPham` WHERE `MaSanPham` = :maSanPham AND `TenSanPham` = :tenSanPham";
    
        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();
    
        try {
            $statement = $connection->prepare($query);
    
            if ($statement !== false) {
                $statement->bindValue(':maSanPham', $maSanPham, PDO::PARAM_INT);
                $statement->bindValue(':tenSanPham', $tenSanPham, PDO::PARAM_STR);
    
                $statement->execute();
    
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
                $isExists = !empty($result) ? 1 : 0;
    
                return (object) [
                    "status" => 200,
                    "message" => "Truy vấn thành công!",
                    "isExists" => $isExists
                ];
            } else {
                throw new PDOException();
            }
        } catch (PDOException $e) {
            return (object) [
                "status" => 400,
                "message" => "Lỗi không thể kiểm tra sản phẩm",
            ];
        } finally {
            $connection = null;
        }
    }

    function createSanPham($tenSanPham, $xuatXu, $thuongHieu, $gia, $theTich, $nongDoCon, $anhMinhHoa, $maLoaiSanPham) {
        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();

        $query = "INSERT INTO `SanPham` (`TenSanPham`, `XuatXu`, `ThuongHieu`, `TheTich`, `NongDoCon`, `Gia`, `AnhMinhHoa`, `MaLoaiSanPham`) 
                    VALUES (:tenSanPham, :xuatXu, :thuongHieu, :theTich, :nongDoCon, :gia, :anhMinhHoa, :maLoaiSanPham)";
        
        try {
            $statement = $connection->prepare($query);

            if ($statement !== false) {
                $statement->bindValue(':tenSanPham', $tenSanPham, PDO::PARAM_STR);
                $statement->bindValue(':xuatXu', $xuatXu, PDO::PARAM_STR);
                $statement->bindValue(':thuongHieu', $thuongHieu, PDO::PARAM_STR);
                $statement->bindValue(':theTich', $theTich, PDO::PARAM_INT);
                $statement->bindValue(':nongDoCon', $nongDoCon, PDO::PARAM_INT);
                $statement->bindValue(':gia', $gia, PDO::PARAM_INT);
                $statement->bindValue(':anhMinhHoa', $anhMinhHoa, PDO::PARAM_STR);
                $statement->bindValue(':maLoaiSanPham', $maLoaiSanPham, PDO::PARAM_INT);

                $statement->execute();

                $id = $connection->lastInsertId();

                return (object) [
                    "status" => 200,
                    "message" => "Thành công",
                    "data" => $id
                ];
            }
        } catch (PDOException $e) {
            return (object) [
                "status" => 400,
                "message" => $e->getMessage()
            ];
        } finally {
            $connection = null;
        }
    }

    function updateTrangThaiSanPham($maSanPham, $trangThai) {
        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();

        $query = "UPDATE `SanPham` SET 
                    `TrangThai` = :trangThai
                WHERE `MaSanPham` = :maSanPham;";

        try {
            $statement = $connection->prepare($query);

            if ($statement !== false) {
                $statement->bindValue(':trangThai', $trangThai, PDO::PARAM_BOOL);
                $statement->bindValue(':maSanPham', $maSanPham, PDO::PARAM_INT);

                $statement->execute();

                if ($statement->rowCount() > 0) {
                    return (object) [
                        "status" => 200,
                        "message" => "Thành công",
                    ];
                } else {
                    throw new PDOException("Không có bản ghi nào được cập nhật");
                }
            }
        } catch (PDOException $e) {
            return (object) [
                "status" => 400,
                "message" => $e->getMessage()
            ];
        } finally {
            $connection = null;
        }
    }

    function updateSanPham($maSanPham, $tenSanPham, $xuatXu, $thuongHieu, $theTich, $nongDoCon, $gia, $soLuongConLai, $anhMinhHoa, $trangThai, $maLoaiSanPham) {
        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();

        $query = "UPDATE `SanPham` SET 
                    `TenSanPham` = :tenSanPham,
                    `XuatXu` = :xuatXu,
                    `ThuongHieu` = :thuongHieu,
                    `TheTich` = :theTich,
                    `NongDoCon` = :nongDoCon,
                    `Gia` = :gia,
                    `SoLuongConLai` = :soLuongConLai,
                    `AnhMinhHoa` = :anhMinhHoa,
                    `TrangThai` = :trangThai,
                    `MaLoaiSanPham` = :maLoaiSanPham
                WHERE `MaSanPham` = :maSanPham";

        try {
            $statement = $connection->prepare($query);

            if ($statement !== false) {
                $statement->bindValue(':maSanPham', $maSanPham, PDO::PARAM_INT);
                $statement->bindValue(':tenSanPham', $tenSanPham, PDO::PARAM_STR);
                $statement->bindValue(':xuatXu', $xuatXu, PDO::PARAM_STR);
                $statement->bindValue(':thuongHieu', $thuongHieu, PDO::PARAM_STR);
                $statement->bindValue(':theTich', $theTich, PDO::PARAM_INT);
                $statement->bindValue(':nongDoCon', $nongDoCon, PDO::PARAM_INT);
                $statement->bindValue(':gia', $gia, PDO::PARAM_INT);
                $statement->bindValue(':soLuongConLai', $soLuongConLai, PDO::PARAM_INT);
                $statement->bindValue(':anhMinhHoa', $anhMinhHoa, PDO::PARAM_STR);
                $statement->bindValue(':trangThai', $trangThai, PDO::PARAM_BOOL);
                $statement->bindValue(':maLoaiSanPham', $maLoaiSanPham, PDO::PARAM_INT);

                $statement->execute();

                if ($statement->rowCount() > 0) {
                    return (object) [
                        "status" => 200,
                        "message" => "Thành công",
                    ];
                } else {
                    throw new PDOException("Không có bản ghi nào được cập nhật");
                }
            }
        } catch (PDOException $e) {
            return (object) [
                "status" => 400,
                "message" => $e->getMessage()
            ];
        } finally {
            $connection = null;
        }
    }

    function giamSoLuongSanPham($maSanPham, $soLuongGiam){
        // Khởi tạo kết nối
        $connection = null;
    
        // Chuẩn bị câu truy vấn
        $query = "UPDATE `SanPham` SET `SoLuongConLai` = `SoLuongConLai` - :soLuongGiam WHERE `MaSanPham` = :maSanPham";
    
        // Khởi tạo kết nối
        $connection = MysqlConfig::getConnection();
    
        try {
            $statement = $connection->prepare($query);
    
            if ($statement !== false) {
                $statement->bindValue(':soLuongGiam', $soLuongGiam, PDO::PARAM_INT);
                $statement->bindValue(':maSanPham', $maSanPham, PDO::PARAM_INT);
    
                $statement->execute();
    
                return (object) [
                    "status" => 200,
                    "message" => "Giảm số lượng sản phẩm thành công!"
                ];
            } else {
                throw new PDOException();
            }
        } catch (PDOException $e) {
            return (object) [
                "status" => 400,
                "message" => "Lỗi không thể tăng số lượng sản phẩm"
            ];
        } finally {
            $connection = null;
        }
    }
 

    function getAllSanPham2(){
        $connection = null;
        $query = "SELECT * FROM `SanPham`";
        $connection = MysqlConfig::getConnection();
        try {
            $statement = $connection->prepare($query);

            if ($statement !== false) {
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                return (object) [
                    "status" => 200,
                    "message" => "Thành công",
                    "data" => $result
                ];
            } else {
                throw new PDOException();
            }
        } catch (PDOException $e) {
            return (object) [
                "status" => 400,
                "message" => $e->getMessage(),
            ];
        } finally {
            $connection = null;
        }
    }
?>
