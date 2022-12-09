<?php
session_destroy();
header('Location: /admin/sign-in');
exit();