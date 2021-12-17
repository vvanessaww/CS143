SELECT familyName
FROM People p1, Prizes p2
WHERE p1.id = p2.id
GROUP BY familyName
HAVING COUNT(*) > 4;