@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Administrador</h1>
@stop


@section('content')
    <div id='calendar'></div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
    <script src="{{asset('js/calendar.js')}}" defer></script>

    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth'
          
        });
        calendar.render();
      });

    </script>
@stop