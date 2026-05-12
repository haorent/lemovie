const container = document.querySelector('.cinema-room');
const seats = document.querySelectorAll('.seat-row .seat:not(.occupied)');
const count = document.getElementById('count');
const total = document.getElementById('total');

const ticketPrice = 25; 

function updateSelectedCount() {
    const selectedSeats = document.querySelectorAll('.seat-row .seat.selected');
    
    const seatIds = [...selectedSeats].map(seat => seat.id);

    const hiddenInput = document.getElementById('hiddenSeatIDs');
    if(hiddenInput) {
        hiddenInput.value = seatIds.join(', ');
    }

    count.innerText = selectedSeats.length;
    total.innerText = "RM " + (selectedSeats.length * 25);
}

container.addEventListener('click', e => {
    if (e.target.classList.contains('seat') && !e.target.classList.contains('occupied')) {
        e.target.classList.toggle('selected');
        updateSelectedCount();
    }
});

const bookingForm = document.getElementById('bookingForm');
const hiddenSeatCount = document.getElementById('hiddenSeatCount');
const hiddenTotalPrice = document.getElementById('hiddenTotalPrice');

bookingForm.addEventListener('submit', function() {
    hiddenSeatCount.value = count.innerText;
    hiddenTotalPrice.value = total.innerText.replace('RM ', ''); 
});