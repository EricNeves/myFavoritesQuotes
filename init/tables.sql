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