<?php

namespace App\Http\Middleware;

use App\Models\{Reservation, User};
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanEditReservation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        $reservation = $request->route('reservation');

        if (!$reservation instanceof Reservation) {
            abort(404);
        }

        if (!$this->canEditReservation($user, $reservation)) {
            abort(403, 'Você não tem permissão para editar esta reserva.');
        }

        return $next($request);
    }

    private function canEditReservation(User $user, Reservation $reservation): bool
    {
        // Use model method instead of hardcoded status
        if (!$reservation->canBeEdited()) {
            return false;
        }

        // Admin permissions
        if ($user->hasAnyRole(['admin', 'auditorium'])) {
            return true;
        }

        // Specific permission
        if ($user->can('edit auditorium')) {
            return true;
        }

        // Owner check
        if ($reservation->user_id === $user->id) {
            return true;
        }

        return false;
    }
}
