@echo off
title que-hide-45min

:loop1

timeout /t 5 /nobreak

php fetch.php

goto loop1

pause
exit