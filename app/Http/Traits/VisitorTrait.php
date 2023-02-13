<?php
namespace App\Http\Traits;

use App\Models\Visitor;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

trait VisitorTrait {

    public function recordVisitor($request)
    {
        $agent = new Agent();
        $visitor = Visitor::where('ipv4', DB::raw('INET_ATON("'.$request->ip().'")'))
            ->where(DB::raw('DATE(created_at)'), now()->translatedFormat('Y-m-d'))
            ->where('page', $request->path());

        if ($visitor->doesntExist()) {
            $platform = $agent->platform();
            $version = $agent->version($platform);

            Visitor::create([
                'ipv4'      => DB::raw('INET_ATON("'.$request->ip().'")'),
                'hits'      => 1,
                'page'      => $request->path(),
                'browser'   => $agent->browser(),
                'mobile'    => $agent->isMobile(),
                'platform'  => $platform,
                'version'   => $version,
                'robot'     => $agent->isRobot() ? $agent->robot() : null,
            ]);
        } else {
            $visitor->increment('hits');
        }
    }

}
