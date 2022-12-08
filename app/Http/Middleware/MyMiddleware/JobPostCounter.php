<?php

namespace App\Http\Middleware\MyMiddleware;

use Closure;
use Illuminate\Http\Request;
use DB;
use Session;

class JobPostCounter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $as = DB::table('premium_application')
            ->select('pa_status')
            ->where('pa_date','>=',date('Y-m-d'))
            ->where('acc_id', Session('user_id'))
            ->orderBy('pa_date', 'DESC')
        ->first();

        $jc = DB::table('job_post')
            ->where('jp_acc_id', session('user_id'))
            ->where('jp_date', date('Y-m-d'))
            ->count();

        Session::put('account_status', $as);
        Session::put('jc_count_today', $jc);

        return $next($request);
    }
}
