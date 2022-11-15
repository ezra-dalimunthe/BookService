<?php

namespace App\Http\Controllers;

use Cache;

class AppCheckController extends Controller
{
/**
 * @OA\Get(
 *   tags={"AppCheck"},
 *   path="/api/v1/env-check",
 *   summary="Utilities to check environment",
 *   @OA\Response(response=200, description="OK"),
 * )
 */
    public function Inspection()
    {
        $result = [];
        $result["environment"] = app()->environment();
        $result["App Name"] = $_ENV["APP_NAME"];

        $result["PHP Version"] = phpversion();
        $result["Laravel Version"] = app()->version();
        // Test database connection
        $result["database server"] = env("DB_HOST");
        try {
            \DB::connection()->getPdo();
            $result["database_connection"] = ["Test Connection" => "OK"];
        } catch (\Exception $e) {
            //report($e);
            $result["database_connection"] = ["Test Connection" => "NOT OK", "Reason: " => $e->getMessage()];
        }

        // test cache driver
        $cacheDriver = $_ENV["CACHE_DRIVER"];
        $result["Cache Driver"] = $cacheDriver;
        switch ($cacheDriver) {
            case 'memcached':
                # code...
                $memcachedLoaded = extension_loaded("Memcached");
                $result["Memcached Loaded"] = $memcachedLoaded;

                $stats = \Cache::getMemcached()->getStats();
                if ($stats == false) {
                } else {
                    $stats = true;
                }
                $result["Memcached OK"] = $stats;

                break;
            case "file":
                $result["Storage Writeable"] = is_writable(storage_path());

                $fsys = \Cache::getDirectory();
                $result["Cache Directory"] = $fsys;
                break;
            case "redis":
                try {
                    $redis_key = 'test_key';
                    $redis_value = 'hello-world';
                    Cache::put($redis_key, $redis_value, $seconds = 60);
                    $value = Cache::get($redis_key);
                    $result["Redis Host"]=env("REDIS_HOST");
                    $result["Redis OK"] = $value == $redis_value;
                } catch (\Throwable $th) {

                    $result["Redis NOT OK"] = $th->getMessage();
                }

            default:
                # code...
                break;
        }
        $result["Cache Prefix"] = \Cache::getPrefix();
        $result["App Debug"] = $_ENV["APP_DEBUG"];
        //$result["loaded Providers"] = app()->loadedProviders;

        return response($result, 200);
    }
    public function clearJwtCache()
    {
        Cache::clear();
        return response()->json(["succes" => true]);
    }

    /**
     * @OA\Get(
     *   tags={"AppCheck"},
     *   path="/api/v1/log-check",
     *   summary="Summary",
     *   @OA\Response(response=200, description="OK"),
     * )
     */
    public function testLog()
    {
        //test if log is writeable.
        $msg = [
            "hello" => "world",
        ];

        try {
            \Log::info("Testing", ["writeable log"]);
            return response()->json(["result" => "OK"]);
        } catch (\Throwable $th) {
            return response()->json(["result" => $th->getMessage()]);
        }

    }
}
