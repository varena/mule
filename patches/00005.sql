ALTER TABLE problem
ADD userId int NOT NULL after status;
UPDATE problem 
SET userId = 1;
