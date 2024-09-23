@extends('layouts.main')

@section('konten')
<br><br>
<div class="container">
    <h2 style="text-align: center">Learning Schedule</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


    <form action="{{ route('learning-schedule.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>

        <div class="mb-3">
            <label for="start" class="form-label">Start Time</label>
            <input type="datetime-local" class="form-control" id="start" name="start" required>
        </div>

        <div class="mb-3">
            <label for="end" class="form-label">End Time</label>
            <input type="datetime-local" class="form-control" id="end" name="end" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Schedule</button>
    </form>

    <h2 class="mt-4" style="text-align: center">Calendar</h2>
    <div id="calendar" style="max-width: 800px; margin: 0 auto; height: 600px;"></div>


    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateForm" method="POST" action="">
                        @csrf
                        @method('POST')
                        <input type="hidden" id="updateId" name="id">

                        <div class="mb-3">
                            <label for="updateTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="updateTitle" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="updateDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="updateDescription" name="description"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="updateStart" class="form-label">Start Time</label>
                            <input type="datetime-local" class="form-control" id="updateStart" name="start" required>
                        </div>

                        <div class="mb-3">
                            <label for="updateEnd" class="form-label">End Time</label>
                            <input type="datetime-local" class="form-control" id="updateEnd" name="end">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Schedule</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.0.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.0.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: function(info, successCallback, failureCallback) {
            fetch("{{ route('learning-schedule.events') }}")
                .then(response => response.json())
                .then(data => successCallback(data))
                .catch(error => {
                    console.error('Error fetching events:', error);
                    failureCallback(error);
                });
        },
        eventClick: function(info) {
            var event = info.event;
            document.getElementById('updateTitle').value = event.title;
            document.getElementById('updateDescription').value = event.extendedProps.description;
            document.getElementById('updateStart').value = event.start.toISOString().slice(0, 16);
            document.getElementById('updateEnd').value = event.end ? event.end.toISOString().slice(0, 16) : '';
            document.getElementById('updateId').value = event.id;

           
            var updateForm = document.getElementById('updateForm');
            updateForm.action = "{{ url('learning-schedule/update') }}/" + event.id;

            var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
            updateModal.show();
        }
    });

    calendar.render();
});
</script>

@endsection

