create table problem (
  id int not null auto_increment,
  name varchar(255) not null,
  status int not null,
  statement blob not null,
  created int not null,
  modified int not null,

  primary key(id),
  unique key(name),
  key(status)
);

insert into problem set name = 'adunare', status = 0, statement = 'Se dau două numere; să se calculeze suma lor.', created = unix_timestamp(), modified = unix_timestamp();
insert into problem set name = 'invizibilă', status = 1, statement = 'Această problemă n-ar trebui să fie vizibilă în mod normal.', created = unix_timestamp(), modified = unix_timestamp();
insert into problem set name = 'scădere', status = 0, statement = 'Se dau două numere; să se calculeze diferența lor.', created = unix_timestamp(), modified = unix_timestamp();
