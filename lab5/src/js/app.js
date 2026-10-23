// app.js — клиентская логика страницы бронирований гостиницы

const bookingForm   = document.getElementById('booking-form');
const guestInput    = document.getElementById('booking-guest');
const roomSelect    = document.getElementById('booking-room');
const checkinInput  = document.getElementById('booking-checkin');
const checkoutInput = document.getElementById('booking-checkout');
const statusFilter  = document.getElementById('status-filter');
const searchInput   = document.getElementById('search-input');
const refreshButton = document.getElementById('refresh-button');
const infoBox       = document.getElementById('info');
const bookingTable  = document.getElementById('booking-table');
const bookingBody   = document.getElementById('booking-body');
const counter       = document.getElementById('counter');

const STATUS_NAMES   = { new: 'Ожидает', in_progress: 'Подтверждена', done: 'Завершена' };
const PRIORITY_NAMES = { low: 'Низкий', medium: 'Средний', high: 'Высокий' };

// ---------- вспомогательные ----------
function showInfo(text, isError) {
  infoBox.textContent = text;
  infoBox.className = isError ? 'message error-message' : 'message';
  infoBox.hidden = false;
}

function updateCounter() {
  const count = bookingBody.children.length;
  counter.textContent = count;
  bookingTable.hidden = (count === 0);
}

function addCell(row, text) {
  const cell = document.createElement('td');
  cell.textContent = text;
  row.appendChild(cell);
  return cell;
}

// ============================================================
// ШАГ 3. Работа с DOM
// ============================================================
function createBookingRow(booking) {
  const row = document.createElement('tr');

  addCell(row, booking.id);
  addCell(row, booking.guest);
  addCell(row, '№' + booking.room);
  addCell(row, booking.checkin);
  addCell(row, booking.checkout);
  addCell(row, STATUS_NAMES[booking.status] || booking.status);

  // ячейка с кнопками действий
  const actions = document.createElement('td');

  const doneButton = document.createElement('button');
  doneButton.textContent = 'Завершить';
  doneButton.addEventListener('click', onDoneClick);
  actions.appendChild(doneButton);

  const deleteButton = document.createElement('button');
  deleteButton.textContent = 'Удалить';
  deleteButton.className = 'danger';
  deleteButton.addEventListener('click', onDeleteClick);
  actions.appendChild(deleteButton);

  row.appendChild(actions);

  row.setAttribute('data-id', booking.id);

  if (booking.status === 'done') {
    row.classList.add('done');
    doneButton.textContent = 'Вернуть';
  }

  return row;
}

function onDoneClick(event) {
  const button = event.target;
  const row = button.closest('tr');
  row.classList.toggle('done');
  const isDone = row.classList.contains('done');
  // 6-я ячейка (индекс 5) — «Статус»
  row.children[5].textContent = isDone ? 'Завершена' : 'Ожидает';
  button.textContent = isDone ? 'Вернуть' : 'Завершить';
  button.setAttribute('title', isDone ? 'Вернуть в работу' : 'Отметить завершённой');
  console.log('Нажата кнопка «Завершить»', row);
}

function onDeleteClick(event) {
  const row = event.target.closest('tr');
  if (!confirm('Удалить бронирование?')) {
    return;
  }
  row.remove();
  updateCounter();
  console.log('Удалена бронь', row);
}

// ============================================================
// ШАГ 2. Обработка событий
// ============================================================
function onFormSubmit(event) {
  event.preventDefault();

  const guest = guestInput.value.trim();
  console.log('Форма отправлена:', guest, roomSelect.value, checkinInput.value, checkoutInput.value);

  const errorBox = document.getElementById('error-guest');
  if (guest.length < 3) {
    errorBox.textContent = 'Введите ФИО гостя (не короче 3 символов)';
    errorBox.style.color = 'red';
    return;
  }
  errorBox.textContent = '';

  const booking = {
    id: '—',
    guest: guest,
    room: roomSelect.value,
    checkin: checkinInput.value || '—',
    checkout: checkoutInput.value || '—',
    status: 'new'
  };

  bookingBody.insertBefore(createBookingRow(booking), bookingBody.firstChild);
  updateCounter();
  infoBox.hidden = true;
  bookingForm.reset();
}

// ============================================================
// ШАГ 4. Асинхронные запросы
// ============================================================
async function loadBookings(status, text) {
  const url = '/api/bookings?status=' + status + '&q=' + encodeURIComponent(text);
  const response = await fetch(url);
  if (!response.ok) {
    throw new Error('Ошибка сервера: ' + response.status);
  }
  return await response.json();
}

async function refreshList() {
  console.log('Фильтр:', statusFilter.value, 'Поиск:', searchInput.value);

  showInfo('Загрузка…', false);
  refreshButton.disabled = true;

  try {
    const bookings = await loadBookings(statusFilter.value, searchInput.value.trim());
    bookingBody.innerHTML = '';
    for (let i = 0; i < bookings.length; i++) {
      bookingBody.appendChild(createBookingRow(bookings[i]));
    }
    updateCounter();
    if (bookings.length === 0) {
      showInfo('Бронирования не найдены', false);
    } else {
      showInfo('Загружено броней: ' + bookings.length, false);
    }
  } catch (error) {
    bookingBody.innerHTML = '';
    updateCounter();
    if (error.message === 'Failed to fetch') {
      showInfo('Нет связи с сервером', true);
    } else {
      showInfo('Не удалось загрузить список. ' + error.message, true);
    }
  } finally {
    refreshButton.disabled = false;
  }
}

// ============================================================
// Обработчики
// ============================================================
bookingForm.addEventListener('submit', onFormSubmit);
refreshButton.addEventListener('click', refreshList);
statusFilter.addEventListener('change', refreshList);
searchInput.addEventListener('input', refreshList);

// ============================================================
// Запуск
// ============================================================
refreshList();