SELECT COUNT(DISTINCT awardYear)
FROM Prizes p1, Organizations p2
WHERE p1.id = p2.id;