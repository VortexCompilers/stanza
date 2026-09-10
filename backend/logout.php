<?php
/*
DECLARATION OF ARTIFICIAL INTELLIGENCE USE

Tool: Claude Code
Stage: Development
Purpose: Correction, review, and refinement of the code
Validation: All changes tested by the dev
*/

session_start();

$_SESSION = [];

session_destroy();

header('Location: ../frontend/landing.php');
exit;