SELECT
U.[GUID],
U.[Nickname],
P.[CropBasename],
P.[IsPrivate]
FROM 
(
[dbo].[i_user] AS U
LEFT JOIN 
[dbo].[i_photo] AS P
ON
P.[UserGUID] = U.[GUID]
)


WHERE 
U.[GUID] = 'a4792450-c237-4494-b1d9-bcbc8569fbf5'
ORDER BY P.[IsPrivate] DESC , P.[PhotoID] ASC
OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY