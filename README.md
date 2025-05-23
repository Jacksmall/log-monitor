## laravel 日志记录主键
####
    1，安装
        composer require jacksmall/log-monitor
    2. 发布
        php artisan vendor:publish --provider="JackSmall\LogMonitor\LogMonitorServiceProvider" --tag="logmonitor-config"
    3. 配置
        配置文件在config/logmonitor.php
        配置文件中，有一个字段default，这个字段是用来记录日志的记录渠道，如果要切换，那么你需要修改这个字段
        目前支持的渠道有：
            1，redis - 默认 database - 0
    4. 在本地的部署
        1. 安装predis
            composer require predis/predis
        2. 配置redis
            在config/database.php中，添加redis配置
        3. 新增laravel LogMonitorMiddleware
            在app/Http/Kernel.php中，添加LogMonitorMiddleware
    LogMonitorMiddleware.php代码如下：
    代码块：
        ```php 
            namespace App\Http\Middleware;
            
            use Closure;
            use Illuminate\Http\Request;
            use Illuminate\Http\Response;
            use Illuminate\Support\Str;
            use Jack\LogMonitor\Facades\LogMonitor;
            
            class LogMonitorMiddleware
            {
                /**
                  * Handle an incoming request.
                  *
                  * @param  \Illuminate\Http\Request  $request
                  * @param  \Closure  $next
                  * @return mixed
                  */
                  public function handle($request, Closure $next)
                  {
                    $traceId = Str::random();
                    $request->attributes->set('traceId', $traceId);
                    return $next($request);
                  }
                
                  public function terminate(Request $request, Response $response)
                  {
                      LogMonitor::log('INFO', 'success', [
                          'traceId' => $request->attributes->get('traceId'),
                          'method' => $request->method(),
                          'url'    => $request->fullUrl(),
                          'ip'     => $request->ip(),
                          'agent'  => $request->userAgent(),
                          'request'  => $request->all(),
                          'headers' => $request->headers->all(),
                          'status' => $response->status(),
                          'response' => $response->getContent()
                      ]);
                  }
            }
        ```
####
    5. 如何使用
        1. 在app/Http/Kernel.php中，添加LogMonitorMiddleware
        2. 在app/Http/Middleware/LogMonitorMiddleware.php中，添加terminate方法
        3. 在app/Http/Middleware/LogMonitorMiddleware.php中，添加handle方法
        4. 在app/Exceptions/Handler.php中，
        ```php
            public function report(Exception $exception)
            {
                LogMonitor::catchException($exception);
                parent::report($exception);
            }
        ```
