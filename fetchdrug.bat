@echo off
title que-hide-45min

:loop1

timeout /t 5 /nobreak

php fetchdrug.php

goto loop1

pause
exit