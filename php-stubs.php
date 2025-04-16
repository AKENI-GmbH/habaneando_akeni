<?php
// Stub for Intelephense to recognize missing PDO constants.
if (!defined('PDO::PGSQL_ATTR_SSL_ROOT_CERT')) {
  define('PDO::PGSQL_ATTR_SSL_ROOT_CERT', 1015); // 1015 is often used as the value in many implementations.
}
