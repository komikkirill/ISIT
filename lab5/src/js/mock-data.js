// mock-data.js — учебный «сервер» гостиницы

const bookings = [
  { id: 1, guest: 'Иванов Иван Иванович',  room: '305', checkin: '2025-06-01', checkout: '2025-06-05', status: 'in_progress', priority: 'high' },
  { id: 2, guest: 'Петрова Анна Сергеевна', room: '102', checkin: '2025-05-10', checkout: '2025-05-12', status: 'done',        priority: 'medium' },
  { id: 3, guest: 'Сидоров Олег Петрович',  room: '210', checkin: '2025-07-20', checkout: '2025-07-25', status: 'new',         priority: 'low' },
  { id: 4, guest: 'Кузнецова Мария Ильинична', room: '101', checkin: '2025-06-15', checkout: '2025-06-18', status: 'in_progress', priority: 'medium' },
  { id: 5, guest: 'Смирнов Дмитрий Алексеевич', room: '305', checkin: '2025-08-01', checkout: '2025-08-03', status: 'new',       priority: 'high' },
  { id: 6, guest: 'Волкова Екатерина Андреевна', room: '210', checkin: '2025-06-10', checkout: '2025-06-14', status: 'done',      priority: 'low' },
  { id: 7, guest: 'Морозов Артём Викторович', room: '102', checkin: '2025-09-05', checkout: '2025-09-07', status: 'new',         priority: 'medium' }
];

const rooms = [
  { id: 1, number: '101', category: 'Стандарт',    price: 2500 },
  { id: 2, number: '102', category: 'Стандарт',    price: 2500 },
  { id: 3, number: '210', category: 'Апартаменты', price: 5000 },
  { id: 4, number: '305', category: 'Люкс',        price: 7000 }
];

const ROUTES = {
  'GET /api/bookings': function (query) {
    return filterList(bookings, query);
  },

  'GET /api/rooms': function () {
    return rooms;
  }
};