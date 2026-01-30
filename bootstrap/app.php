<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        $middleware->redirectUsersTo(function () {
            $user = Auth::user();

            if (!$user) {
                return '/login';
            }

            return match ($user->role) {
                'admin' => route('admin.dashboard'),
                'teacher' => route('teacher.dashboard'),
                'student' => route('student.dashboard'),
                default => '/',
            };
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            return response()->redirectToRoute('page.not.found');
        });

        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e) {
            return response()->redirectToRoute('access.denied');
        });
    })->create();
