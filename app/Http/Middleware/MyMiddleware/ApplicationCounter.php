<?php

namespace App\Http\Middleware\MyMiddleware;

use Closure;
use Illuminate\Http\Request;
use DB;
use Session;

class ApplicationCounter
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

        $ja = DB::table('job_application')
            ->where('ja_date','=',date('Y-m-d'))
            ->where('ja_applicant_id', Session('user_id'))
        ->first();

        $as = DB::table('premium_application')
            ->select('pa_status')
            ->where('pa_date','>=',date('Y-m-d'))
            ->where('acc_id', Session('user_id'))
            ->orderBy('pa_date', 'DESC')
        ->first();

        Session::put('account_status', $as);
        Session::put('ja_count_today', $ja);

        return $next($request);
    }
}
