<?php

class MysqlConfig
{

  private static $servername = "localhost"; // Tên máy chủ
  private static $username = "root"; // Tên người dùng MySQL
  private static $password = "0204"; // Mật khẩu MySQL
  private static $database = "SoftwareTechnology_Database"; // Tên cơ sở dữ liệu
  private static $port = 3306;
  public static function getConnection()
  {

    try {
      //Tạo connection
      $conn = new PDO(
        "mysql:host=" . self::$servername . ";
                                port=" . self::$port . ";
                                dbname=" . self::$database,
        self::$username,
        self::$password,
      );

      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
    } catch (PDOException $e) {
      echo "Kết nối không thành công: " . $e->getMessage();
    }
  }
}
