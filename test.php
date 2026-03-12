<?php
echo function_exists('sqlsrv_connect')
    ? 'sqlsrv พร้อมใช้งาน'
    : 'sqlsrv ยังไม่พร้อม';