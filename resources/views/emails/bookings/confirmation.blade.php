<x-mail::message>
# Prenotazione Confermata

Ciao **{{ $booking->user->name }}**,

La tua prenotazione è stata ricevuta con successo.

**Dottore:** {{ $booking->slot->doctor->name }}  
**Servizio:** {{ $booking->slot->service->name }}  
**Data:** {{ $booking->slot->starts_at->format('d/m/Y H:i') }}

Grazie,<br>
{{ config('app.name') }}
</x-mail::message>