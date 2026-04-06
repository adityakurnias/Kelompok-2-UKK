@echo off
setlocal enabledelayedexpansion

echo ============================================
echo   Running composer setup for all projects
echo ============================================
echo.

set "ROOT=%~dp0"

for /d %%D in ("%ROOT%*") do (
    set "PROJECT=%%~nxD"

    REM Skip hidden folders (starting with .)
    if "!PROJECT:~0,1!" NEQ "." (
        echo [*] Project: !PROJECT!
        echo     Path: %%D

        if exist "%%D\composer.json" (
            pushd "%%D"
            echo     Running composer setup...
            composer update
            composer run setup 
            if !ERRORLEVEL! NEQ 0 (
                echo     [FAILED] composer setup failed for !PROJECT!
            ) else (
                echo     [OK] Done.
            )
            popd
        ) else (
            echo     [SKIP] No composer.json found, skipping.
        )
        echo.
    )
)

echo ============================================
echo   All projects processed.
echo ============================================
pause
