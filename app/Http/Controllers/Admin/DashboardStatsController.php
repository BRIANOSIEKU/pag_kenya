<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class DashboardStatsController extends Controller
{
    public function index(): JsonResponse
    {
        try {

            // Cache for 5 seconds (fast refresh)
            $stats = Cache::remember('dashboard_stats', 5, function () {

                $totalAssemblies = DB::table('assemblies')->count();

                $districtLeaders = DB::table('district_leaders')->count();
                $committeeLeaders = DB::table('committee_leader')->count();

                $totalDistricts = DB::table('districts')->count();

                // MEMBERS
                $totalMembers = DB::table('assembly_members')->count();

                // =========================
                // 🔵 NATIONAL PASTORAL STATS
                // =========================
                $pendingPastors = DB::table('pastoral_teams')
                    ->where('status', 'pending')
                    ->count();

                $approvedPastors = DB::table('pastoral_teams')
                    ->where('status', 'approved')
                    ->count();

                $rejectedPastors = DB::table('pastoral_teams')
                    ->where('status', 'rejected')
                    ->count();

                return [
                    'totalMembers'    => $totalMembers,
                    'totalAssemblies' => $totalAssemblies,
                    'totalLeaders'    => $districtLeaders + $committeeLeaders,
                    'totalDistricts'  => $totalDistricts,

                    // NEW
                    'pendingPastors'  => $pendingPastors,
                    'approvedPastors' => $approvedPastors,
                    'rejectedPastors' => $rejectedPastors,
                ];
            });

            return response()->json([
                'success' => true,

                'totalMembers'    => $stats['totalMembers'],
                'totalAssemblies' => $stats['totalAssemblies'],
                'totalLeaders'    => $stats['totalLeaders'],
                'totalDistricts'  => $stats['totalDistricts'],

                // NEW
                'pendingPastors'  => $stats['pendingPastors'],
                'approvedPastors' => $stats['approvedPastors'],
                'rejectedPastors' => $stats['rejectedPastors'],
            ]);

        } catch (\Exception $e) {

            Log::error('Dashboard Stats Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'totalMembers'    => 0,
                'totalAssemblies' => 0,
                'totalLeaders'    => 0,
                'totalDistricts'  => 0,

                // NEW SAFE FALLBACKS
                'pendingPastors'  => 0,
                'approvedPastors' => 0,
                'rejectedPastors' => 0,
            ], 500);
        }
    }
}