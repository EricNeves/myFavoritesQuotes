CREATE TABLE IF NOT EXISTS qt_users (
  id         SERIAL PRIMARY KEY,
  username   VARCHAR(150) NOT NULL,
  email      VARCHAR(255) NOT NULL UNIQUE,
  password   VARCHAR(255) NOT NULL,
  created_at timestamp NOT NULL,
  updated_at timestamp
);

CREATE TABLE IF NOT EXISTS qt_quotes (
  id         SERIAL PRIMARY KEY,
  quote      TEXT NOT NULL UNIQUE,
  author     VARCHAR(150) NOT NULL,
  created_at timestamp NOT NULL,
  updated_at timestamp,
  user_id    INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES qt_users (id)
);

INSERT INTO qt_users (id, username, email, password, created_at) VALUES 
(1, 'Richard',    'rich@email.com',      '$2y$10$2WcXBDEZO/mQh25xe8T5xel0Bf2kMy8ARkvZHuZP.Pbhhp2TpHcca', 'NOW()'),
(2, 'Joe John',   'john@email.com',      '$2y$10$2WcXBDEZO/mQh25xe8T5xel0Bf2kMy8ARkvZHuZP.Pbhhp2TpHcca', 'NOW()'),
(3, 'Elizabeth',  'elizabeth@email.com', '$2y$10$2WcXBDEZO/mQh25xe8T5xel0Bf2kMy8ARkvZHuZP.Pbhhp2TpHcca', 'NOW()');

INSERT INTO qt_quotes (quote, author, created_at, user_id) VALUES 
('Dê uma máscara ao homem e ele lhe dará a verdade!',      'Oscar Wilde',         'NOW()', 1),
('Como não foi genial, não teve inimigos.',                'Oscar Wilde',         'NOW()', 2),
('As máquinas me surpreendem muito frequentemente.',       'Alan Turing',         'NOW()', 2),
('A falta de evidência não é uma evidência da ausência..', 'Carl Sagan',          'NOW()', 3),
('Vence o medo e vencerás a morte.',                       'Alexandre, o Grande', 'NOW()', 1);