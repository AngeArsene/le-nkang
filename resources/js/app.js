/* Portraits intégrés (aucun dossier d'images nécessaire) */
const IMG = {
    1: "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA4MDAgMTAwMCIgcm9sZT0iaW1nIiBhcmlhLWxhYmVsbGVkYnk9InRpdGxlIj4NCiAgPHRpdGxlIGlkPSJ0aXRsZSI+UG9ydHJhaXQgYWJzdHJhaXQgZW4gbHVtacOocmUgdHVycXVvaXNlIGV0IGFtYnJlPC90aXRsZT4NCiAgPGRlZnM+DQogICAgPGxpbmVhckdyYWRpZW50IGlkPSJiYWNrIiB4MT0iMCIgeTE9IjAiIHgyPSIxIiB5Mj0iMSI+PHN0b3Agc3RvcC1jb2xvcj0iIzE0MmUzMiIvPjxzdG9wIG9mZnNldD0iLjUyIiBzdG9wLWNvbG9yPSIjMTcyMDJiIi8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjMzIxZTM2Ii8+PC9saW5lYXJHcmFkaWVudD4NCiAgICA8cmFkaWFsR3JhZGllbnQgaWQ9ImxpZ2h0Ij48c3RvcCBzdG9wLWNvbG9yPSIjMmRkNGJmIiBzdG9wLW9wYWNpdHk9Ii42Ii8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjMmRkNGJmIiBzdG9wLW9wYWNpdHk9IjAiLz48L3JhZGlhbEdyYWRpZW50Pg0KICAgIDxsaW5lYXJHcmFkaWVudCBpZD0ic2tpbiIgeDI9Ii45IiB5Mj0iMSI+PHN0b3Agc3RvcC1jb2xvcj0iI2Q1YWE4MiIvPjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iIzgwNWM1NSIvPjwvbGluZWFyR3JhZGllbnQ+DQogIDwvZGVmcz4NCiAgPHJlY3Qgd2lkdGg9IjgwMCIgaGVpZ2h0PSIxMDAwIiBmaWxsPSJ1cmwoI2JhY2spIi8+DQogIDxlbGxpcHNlIGN4PSI2MDAiIGN5PSIyOTAiIHJ4PSIyODAiIHJ5PSIzNDAiIGZpbGw9InVybCgjbGlnaHQpIi8+DQogIDxwYXRoIGQ9Ik0wIDc5MFEyMTUgNjYwIDQxMCA3NjB0MzkwLTIwdjI2MEgwWiIgZmlsbD0iIzBmMTMxZCIvPg0KICA8cGF0aCBkPSJNMjAwIDEwMDBxMzgtMjEwIDEwMy0yODZsOTQtNTYgMTExIDM1cTExMiA3MiAxNDQgMzA3WiIgZmlsbD0iIzI1MmMzOCIvPg0KICA8cGF0aCBkPSJNMzEzIDQxMnEtNC0xNzggMTEyLTE4OCAxNDQtMTQgMTU0IDE2OWwtMjUgMTMwcS0yNyAxMTQtMTI2IDExNy05NCAzLTEyMy0xMTNaIiBmaWxsPSJ1cmwoI3NraW4pIi8+DQogIDxwYXRoIGQ9Ik0yOTMgNDA4cS0zNS0xNjkgNzItMjQxIDgyLTU1IDE4NSAyIDgzIDQ3IDU2IDIyNGwtMzctOThxLTY2IDYtMTA5LTQ3LTM3IDY5LTEzNyA4MVoiIGZpbGw9IiMxNDE1MWMiLz4NCiAgPHBhdGggZD0iTTMyOSA0NDRxMjkgMTAgNTUgMG03MyAwcTI3IDEwIDU0LTEiIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzJkMjAyNSIgc3Ryb2tlLXdpZHRoPSIxMSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+DQogIDxwYXRoIGQ9Ik00MjIgNTEwcTE5IDEyIDM4IDAiIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzU3M2EzOCIgc3Ryb2tlLXdpZHRoPSI4IiBzdHJva2UtbGluZWNhcD0icm91bmQiLz4NCiAgPHBhdGggZD0iTTM2MiA1ODdxNjEgMzggMTIzIDAiIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzYzM2M0MiIgc3Ryb2tlLXdpZHRoPSIxMSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+DQogIDxwYXRoIGQ9Ik0yMjggOTk2cTYyLTE4NyAxNzktMjAzbC00NSAyMDdabTQwOCAwcS01Mi0xNzQtMTgzLTIwNWw1MSAyMDlaIiBmaWxsPSIjMzk0NTUwIi8+DQogIDxjaXJjbGUgY3g9IjMxNiIgY3k9IjQ3MiIgcj0iNyIgZmlsbD0iI2RmYzhhNCIvPjxjaXJjbGUgY3g9IjUzNiIgY3k9IjQ3MiIgcj0iNyIgZmlsbD0iI2RmYzhhNCIvPg0KICA8cGF0aCBkPSJNODUgMTQyaDJ2NzAwaC0yek03MDggODloMnY1NTBoLTJ6IiBmaWxsPSIjYzlhMjRiIiBvcGFjaXR5PSIuNCIvPg0KPC9zdmc+DQo=",
    2: "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA4MDAgMTAwMCIgcm9sZT0iaW1nIiBhcmlhLWxhYmVsbGVkYnk9InRpdGxlIj4NCiAgPHRpdGxlIGlkPSJ0aXRsZSI+U2lsaG91ZXR0ZSBhYnN0cmFpdGUgYmFpZ27DqWUgZGUgdmlvbGV0IGV0IGRlIGJsZXU8L3RpdGxlPg0KICA8ZGVmcz4NCiAgICA8bGluZWFyR3JhZGllbnQgaWQ9ImJhY2siIHgxPSIwIiB5MT0iMCIgeDI9IjEiIHkyPSIxIj48c3RvcCBzdG9wLWNvbG9yPSIjMWMxOTMxIi8+PHN0b3Agb2Zmc2V0PSIuNTUiIHN0b3AtY29sb3I9IiMxNzFiMmEiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiMyNTIwMmMiLz48L2xpbmVhckdyYWRpZW50Pg0KICAgIDxyYWRpYWxHcmFkaWVudCBpZD0iaGFsbyI+PHN0b3Agc3RvcC1jb2xvcj0iIzZkNWJkMCIgc3RvcC1vcGFjaXR5PSIuNzIiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiM2ZDViZDAiIHN0b3Atb3BhY2l0eT0iMCIvPjwvcmFkaWFsR3JhZGllbnQ+DQogICAgPGxpbmVhckdyYWRpZW50IGlkPSJza2luIiB4Mj0iMSIgeTI9IjEiPjxzdG9wIHN0b3AtY29sb3I9IiNkOGIxOTAiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiM5NjZkNjYiLz48L2xpbmVhckdyYWRpZW50Pg0KICA8L2RlZnM+DQogIDxyZWN0IHdpZHRoPSI4MDAiIGhlaWdodD0iMTAwMCIgZmlsbD0idXJsKCNiYWNrKSIvPg0KICA8ZWxsaXBzZSBjeD0iMjQwIiBjeT0iMzE1IiByeD0iMzAwIiByeT0iMzQ1IiBmaWxsPSJ1cmwoI2hhbG8pIi8+DQogIDxwYXRoIGQ9Ik04MCA4MjJRMjg2IDcxNiA0NzQgODA4dDMyNi05djIwMUg4MFoiIGZpbGw9IiMxMTEzMWQiLz4NCiAgPHBhdGggZD0iTTE3NiAxMDAwcTU4LTIwOSAxNzMtMjcwbDc4LTI3IDEwNyA1N3ExMDcgNzggMTMwIDI0MFoiIGZpbGw9IiMzMTM0NDgiLz4NCiAgPHBhdGggZD0iTTMxNCA0MTVxLTUtMTY0IDkxLTE5NyAxMDktMzggMTcwIDU2IDQ0IDY3IDIwIDE5NS0yNSAxNDUtMTQxIDE1Ni05MS02LTEyNS0xMjBaIiBmaWxsPSJ1cmwoI3NraW4pIi8+DQogIDxwYXRoIGQ9Ik0yODggNDQwcS0zNy0xNzUgNzAtMjQ0IDEyNy04MSAyMjQgOSA1MyA1MCAzNyAyMTdsLTMyLTEwM3EtOTYgMTEtMTUwLTYyLTMxIDc1LTEyNyA4N1oiIGZpbGw9IiMxNTE3MjIiLz4NCiAgPHBhdGggZD0iTTM0NCA0NTlxMjYgOCA1MCAwbTc2IDBxMjUgNyA0OS0xIiBmaWxsPSJub25lIiBzdHJva2U9IiMzMzIzMmEiIHN0cm9rZS13aWR0aD0iMTAiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPg0KICA8cGF0aCBkPSJNNDI5IDUxN3ExOSA5IDM2LTEiIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzZjNGU0ZSIgc3Ryb2tlLXdpZHRoPSI4IiBzdHJva2UtbGluZWNhcD0icm91bmQiLz4NCiAgPHBhdGggZD0iTTM2OSA1OTBxNTIgMzIgMTA1LTEiIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzc1NDk1MSIgc3Ryb2tlLXdpZHRoPSIxMCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+DQogIDxwYXRoIGQ9Ik0yMTUgOTk2cTYwLTE3MSAxNjAtMTk5bC01MCAyMDVabTQyNCAwcS01Mi0xODItMTYwLTIwNGw0NSAyMTBaIiBmaWxsPSIjNDU0MzU3Ii8+DQogIDxwYXRoIGQ9Ik0xMzggMTIwdjYyMG01MDYtNjQ1djQ0MCIgc3Ryb2tlPSIjYTk5NGYwIiBzdHJva2Utb3BhY2l0eT0iLjM0IiBzdHJva2Utd2lkdGg9IjIiLz4NCiAgPGNpcmNsZSBjeD0iMzkzIiBjeT0iNDc1IiByPSI2IiBmaWxsPSIjZTBjM2E0Ii8+PGNpcmNsZSBjeD0iNTE1IiBjeT0iNDc1IiByPSI2IiBmaWxsPSIjZTBjM2E0Ii8+DQo8L3N2Zz4NCg==",
    3: "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA4MDAgMTAwMCIgcm9sZT0iaW1nIiBhcmlhLWxhYmVsbGVkYnk9InRpdGxlIj4NCiAgPHRpdGxlIGlkPSJ0aXRsZSI+UG9ydHJhaXQgZ3JhcGhpcXVlIGVuIGx1bWnDqHJlIHJvc2UgZXQgY3VpdnJlPC90aXRsZT4NCiAgPGRlZnM+DQogICAgPGxpbmVhckdyYWRpZW50IGlkPSJiYWNrIiB4MT0iMCIgeTE9IjEiIHgyPSIxIiB5Mj0iMCI+PHN0b3Agc3RvcC1jb2xvcj0iIzI2MWEyNSIvPjxzdG9wIG9mZnNldD0iLjUiIHN0b3AtY29sb3I9IiMxOTE4MjEiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiMzMDIwMmQiLz48L2xpbmVhckdyYWRpZW50Pg0KICAgIDxyYWRpYWxHcmFkaWVudCBpZD0iaGFsbyI+PHN0b3Agc3RvcC1jb2xvcj0iI2U4NzlhNiIgc3RvcC1vcGFjaXR5PSIuNDgiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiNlODc5YTYiIHN0b3Atb3BhY2l0eT0iMCIvPjwvcmFkaWFsR3JhZGllbnQ+DQogICAgPGxpbmVhckdyYWRpZW50IGlkPSJza2luIiB4Mj0iMSIgeTI9Ii44Ij48c3RvcCBzdG9wLWNvbG9yPSIjZTBiNzhlIi8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjOWQ3MDYwIi8+PC9saW5lYXJHcmFkaWVudD4NCiAgPC9kZWZzPg0KICA8cmVjdCB3aWR0aD0iODAwIiBoZWlnaHQ9IjEwMDAiIGZpbGw9InVybCgjYmFjaykiLz4NCiAgPGVsbGlwc2UgY3g9IjU3MCIgY3k9IjMwMCIgcng9IjMwMCIgcnk9IjM2MCIgZmlsbD0idXJsKCNoYWxvKSIvPg0KICA8cGF0aCBkPSJNMCA3OTVxMTc4LTY2IDM4Mi02IDIyMCA2NSA0MTgtMzB2MjQxSDBaIiBmaWxsPSIjMTIxMzFhIi8+DQogIDxwYXRoIGQ9Ik0xNTAgMTAwMHEyOS0xODMgMTUzLTI3MWw5OS00MiA5NCA0MXExNDAgNzEgMTYwIDI3MloiIGZpbGw9IiMzODI5MzYiLz4NCiAgPHBhdGggZD0iTTMwNSA0MjBxLTIxLTE0NCA0Ni0yMDcgODMtNzggMTkxLTIxIDg0IDQ0IDY4IDIxNi0xMiAxNDEtMTM5IDE2MS0xMTMtNC0xNTEtMTQ5WiIgZmlsbD0idXJsKCNza2luKSIvPg0KICA8cGF0aCBkPSJNMjc3IDQ1N3EtMjUtMTkwIDc1LTI2NSAxMTEtODMgMjIzLTEgNjMgNDYgNjYgMTk3bC01MC02MnEtOTcgMTktMTQ2LTU4LTQ4IDgzLTE1MCA4NVoiIGZpbGw9IiMxNzE1MWMiLz4NCiAgPHBhdGggZD0iTTMzNCA0NjVxMjcgNyA1MCAwbTc3IDBxMjYgNyA0OSAwIiBmaWxsPSJub25lIiBzdHJva2U9IiMzODI3MmEiIHN0cm9rZS13aWR0aD0iMTAiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPg0KICA8cGF0aCBkPSJNNDI0IDUyNXExOSAxMiAzNyAwIiBmaWxsPSJub25lIiBzdHJva2U9IiM2ODQ5NDIiIHN0cm9rZS13aWR0aD0iOCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+DQogIDxwYXRoIGQ9Ik0zNjAgNTk5cTY1IDM5IDEyNiAwIiBmaWxsPSJub25lIiBzdHJva2U9IiM4MTRiNTEiIHN0cm9rZS13aWR0aD0iMTAiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPg0KICA8cGF0aCBkPSJNMjA0IDEwMDBxNzItMTcxIDE4My0yMTJsLTM4IDIxMlptNDIwIDBxLTYwLTE3OS0xODAtMjEybDQyIDIxMloiIGZpbGw9IiM0ZTM3NDciLz4NCiAgPHBhdGggZD0iTTkxIDE3MGgzdjYxMGgtM3ptNjI0IDcwaDN2NDcwaC0zeiIgZmlsbD0iI2U4NzlhNiIgb3BhY2l0eT0iLjQ4Ii8+DQogIDxjaXJjbGUgY3g9IjM1OCIgY3k9IjQ4MSIgcj0iNiIgZmlsbD0iI2U1YzVhMCIvPjxjaXJjbGUgY3g9IjUxMiIgY3k9IjQ4MSIgcj0iNiIgZmlsbD0iI2U1YzVhMCIvPg0KPC9zdmc+DQo=",
    4: "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA4MDAgMTAwMCIgcm9sZT0iaW1nIiBhcmlhLWxhYmVsbGVkYnk9InRpdGxlIj4NCiAgPHRpdGxlIGlkPSJ0aXRsZSI+SWxsdXN0cmF0aW9uIGRlIHBvcnRyYWl0IHNvbWJyZSBhdmVjIGhhbG8gw6ltZXJhdWRlPC90aXRsZT4NCiAgPGRlZnM+DQogICAgPGxpbmVhckdyYWRpZW50IGlkPSJiYWNrIiB4MT0iLjEiIHkxPSIwIiB4Mj0iLjkiIHkyPSIxIj48c3RvcCBzdG9wLWNvbG9yPSIjMTAyYTI3Ii8+PHN0b3Agb2Zmc2V0PSIuNSIgc3RvcC1jb2xvcj0iIzE1MWIyMiIvPjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iIzE3MmQzNSIvPjwvbGluZWFyR3JhZGllbnQ+DQogICAgPHJhZGlhbEdyYWRpZW50IGlkPSJoYWxvIj48c3RvcCBzdG9wLWNvbG9yPSIjMmRkNGJmIiBzdG9wLW9wYWNpdHk9Ii41NSIvPjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iIzJkZDRiZiIgc3RvcC1vcGFjaXR5PSIwIi8+PC9yYWRpYWxHcmFkaWVudD4NCiAgICA8bGluZWFyR3JhZGllbnQgaWQ9InNraW4iPjxzdG9wIHN0b3AtY29sb3I9IiNiNzg2NmQiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiM2ODRiNGQiLz48L2xpbmVhckdyYWRpZW50Pg0KICA8L2RlZnM+DQogIDxyZWN0IHdpZHRoPSI4MDAiIGhlaWdodD0iMTAwMCIgZmlsbD0idXJsKCNiYWNrKSIvPg0KICA8ZWxsaXBzZSBjeD0iMzY1IiBjeT0iMzIwIiByeD0iMzI1IiByeT0iMzYwIiBmaWxsPSJ1cmwoI2hhbG8pIi8+DQogIDxwYXRoIGQ9Ik0wIDgwOHEyMDYtMTAzIDQxOC0yMHQzODItNDN2MjU1SDBaIiBmaWxsPSIjMGQxNTFhIi8+DQogIDxwYXRoIGQ9Ik0xODMgMTAwMHE0NS0xOTYgMTU3LTI2NWwxMDgtNDAgMTExIDU4cTEyMiA3NSAxNDcgMjQ3WiIgZmlsbD0iIzIyMzQzYSIvPg0KICA8cGF0aCBkPSJNMzA5IDQxOHEtMTItMTc3IDgzLTIxOCAxMTktNTMgMTg3IDQ3IDQ1IDY4IDI0IDE4OS0yNCAxNDQtMTUxIDE1OC0xMDYtMTAtMTMzLTE3NloiIGZpbGw9InVybCgjc2tpbikiLz4NCiAgPHBhdGggZD0iTTI4NSA0MzlxLTI4LTE3NSA2OC0yNDcgOTMtNjkgMTk4LTYgNzYgNDYgNjcgMjMxbC00My05M3EtNzMgMTAtMTI1LTYyLTQwIDc3LTE0MCA4N1oiIGZpbGw9IiMxMDE3MWIiLz4NCiAgPHBhdGggZD0iTTMzOSA0NThxMjcgMTAgNTEgMG03OCAwcTI2IDkgNDktMSIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjMzQyNDJiIiBzdHJva2Utd2lkdGg9IjEwIiBzdHJva2UtbGluZWNhcD0icm91bmQiLz4NCiAgPHBhdGggZD0iTTQyNSA1MThxMTcgMTIgMzUgMCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjNWEzZTNkIiBzdHJva2Utd2lkdGg9IjgiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPg0KICA8cGF0aCBkPSJNMzU5IDU5MnE2MiAzNyAxMjQgMCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjNjk0MTQ5IiBzdHJva2Utd2lkdGg9IjExIiBzdHJva2UtbGluZWNhcD0icm91bmQiLz4NCiAgPHBhdGggZD0iTTIxOSAxMDAwcTYzLTE4NyAxNjgtMjE4bC00NCAyMThabTQwNSAwcS01NS0xNzMtMTcxLTIxNWw0MiAyMTVaIiBmaWxsPSIjMzA0NzRhIi8+DQogIDxwYXRoIGQ9Ik0xMjAgMTEydjcyMG01NzUtNjc1djQ3MCIgc3Ryb2tlPSIjOGJlNWQxIiBzdHJva2Utb3BhY2l0eT0iLjI4IiBzdHJva2Utd2lkdGg9IjIiLz4NCiAgPGNpcmNsZSBjeD0iMzY2IiBjeT0iNDc3IiByPSI2IiBmaWxsPSIjZDhiOTk0Ii8+PGNpcmNsZSBjeD0iNTE3IiBjeT0iNDc3IiByPSI2IiBmaWxsPSIjZDhiOTk0Ii8+DQo8L3N2Zz4NCg==",
    5: "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA4MDAgMTAwMCIgcm9sZT0iaW1nIiBhcmlhLWxhYmVsbGVkYnk9InRpdGxlIj4NCiAgPHRpdGxlIGlkPSJ0aXRsZSI+UG9ydHJhaXQgc3R5bGlzw6kgYXV4IGx1bWnDqHJlcyBibGV1IG51aXQgZXQgb3IgZG91eDwvdGl0bGU+DQogIDxkZWZzPg0KICAgIDxsaW5lYXJHcmFkaWVudCBpZD0iYmFjayIgeDE9IjAiIHkxPSIwIiB4Mj0iMSIgeTI9IjEiPjxzdG9wIHN0b3AtY29sb3I9IiMxMDFiMmUiLz48c3RvcCBvZmZzZXQ9Ii41NiIgc3RvcC1jb2xvcj0iIzE3MWEyNiIvPjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iIzM1MmIyNCIvPjwvbGluZWFyR3JhZGllbnQ+DQogICAgPHJhZGlhbEdyYWRpZW50IGlkPSJoYWxvIj48c3RvcCBzdG9wLWNvbG9yPSIjNTE3NmE1IiBzdG9wLW9wYWNpdHk9Ii41NiIvPjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iIzUxNzZhNSIgc3RvcC1vcGFjaXR5PSIwIi8+PC9yYWRpYWxHcmFkaWVudD4NCiAgICA8bGluZWFyR3JhZGllbnQgaWQ9InNraW4iIHgyPSIuOCIgeTI9IjEiPjxzdG9wIHN0b3AtY29sb3I9IiNkMGEzODIiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiM4YzYyNWIiLz48L2xpbmVhckdyYWRpZW50Pg0KICA8L2RlZnM+DQogIDxyZWN0IHdpZHRoPSI4MDAiIGhlaWdodD0iMTAwMCIgZmlsbD0idXJsKCNiYWNrKSIvPg0KICA8ZWxsaXBzZSBjeD0iNjAwIiBjeT0iMzUwIiByeD0iMzAwIiByeT0iMzcwIiBmaWxsPSJ1cmwoI2hhbG8pIi8+DQogIDxwYXRoIGQ9Ik0wIDc4N3EyMjAtNTcgNDE1IDI0dDM4NS0yMXYyMTBIMFoiIGZpbGw9IiMxMTE0MWMiLz4NCiAgPHBhdGggZD0iTTE3NCAxMDAwcTQwLTE4MCAxNDctMjU2bDEwNi00OSAxMDYgNTNxMTM2IDc5IDE2NSAyNTJaIiBmaWxsPSIjMjczMDNjIi8+DQogIDxwYXRoIGQ9Ik0zMDYgNDE0cS0xNS0xNTMgNjMtMjExIDEwMy03NyAyMDEtNSA3OSA1OSA0NSAyMzAtMjcgMTMwLTEzOCAxNTEtMTA2LTEwLTE0NC0xNjVaIiBmaWxsPSJ1cmwoI3NraW4pIi8+DQogIDxwYXRoIGQ9Ik0yNzkgNDQ0cS0yOC0xNjYgNjYtMjQ3IDExMC05MyAyMjEtNyA3MCA1NSA1MSAyNDVsLTUyLTEwNHEtNzkgMTctMTM0LTYxLTM2IDgwLTEzNiA5MVoiIGZpbGw9IiMxMzE2MjAiLz4NCiAgPHBhdGggZD0iTTMzOCA0NjVxMjggOSA1MC0xbTc1IDBxMjcgOSA1MC0xIiBmaWxsPSJub25lIiBzdHJva2U9IiMzODI1MmEiIHN0cm9rZS13aWR0aD0iMTAiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPg0KICA8cGF0aCBkPSJNNDI2IDUxOXExNyAxMyAzNiAwIiBmaWxsPSJub25lIiBzdHJva2U9IiM1YzQwM2QiIHN0cm9rZS13aWR0aD0iOCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+DQogIDxwYXRoIGQ9Ik0zNjAgNTkwcTYzIDM3IDEyNiAwIiBmaWxsPSJub25lIiBzdHJva2U9IiM3NzQ3NGEiIHN0cm9rZS13aWR0aD0iMTAiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPg0KICA8cGF0aCBkPSJNMjA2IDEwMDBxNjctMTcxIDE2NC0yMDRsLTQyIDIwNFptNDIwIDBxLTYwLTE4MS0xNzUtMjA1bDQ0IDIwNVoiIGZpbGw9IiMzYzQxNDkiLz4NCiAgPGNpcmNsZSBjeD0iMzY1IiBjeT0iNDc4IiByPSI2IiBmaWxsPSIjZGZjNGEyIi8+PGNpcmNsZSBjeD0iNTE1IiBjeT0iNDc4IiByPSI2IiBmaWxsPSIjZGZjNGEyIi8+DQogIDxwYXRoIGQ9Ik04MiAxNzJoM3Y1NTBoLTN6bTYzOCAxN2gzdjYzMGgtM3oiIGZpbGw9IiNjOWEyNGIiIG9wYWNpdHk9Ii40Ii8+DQo8L3N2Zz4NCg==",
    6: "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA4MDAgMTAwMCIgcm9sZT0iaW1nIiBhcmlhLWxhYmVsbGVkYnk9InRpdGxlIj4NCiAgPHRpdGxlIGlkPSJ0aXRsZSI+UG9ydHJhaXQgYWJzdHJhaXQgdGVpbnTDqSBkZSBwcnVuZSBldCBkZSByb3NlPC90aXRsZT4NCiAgPGRlZnM+DQogICAgPGxpbmVhckdyYWRpZW50IGlkPSJiYWNrIiB4MT0iMCIgeTE9IjEiIHgyPSIuOCIgeTI9IjAiPjxzdG9wIHN0b3AtY29sb3I9IiMyNTE2MmEiLz48c3RvcCBvZmZzZXQ9Ii41NiIgc3RvcC1jb2xvcj0iIzE3MTgyMiIvPjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iIzMwMjIzOSIvPjwvbGluZWFyR3JhZGllbnQ+DQogICAgPHJhZGlhbEdyYWRpZW50IGlkPSJoYWxvIj48c3RvcCBzdG9wLWNvbG9yPSIjYmQ2Y2FhIiBzdG9wLW9wYWNpdHk9Ii41Ii8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjYmQ2Y2FhIiBzdG9wLW9wYWNpdHk9IjAiLz48L3JhZGlhbEdyYWRpZW50Pg0KICAgIDxsaW5lYXJHcmFkaWVudCBpZD0ic2tpbiI+PHN0b3Agc3RvcC1jb2xvcj0iI2UwYjE4ZCIvPjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iIzk2NmM2NCIvPjwvbGluZWFyR3JhZGllbnQ+DQogIDwvZGVmcz4NCiAgPHJlY3Qgd2lkdGg9IjgwMCIgaGVpZ2h0PSIxMDAwIiBmaWxsPSJ1cmwoI2JhY2spIi8+DQogIDxlbGxpcHNlIGN4PSIyNDMiIGN5PSIzMjgiIHJ4PSIzMDAiIHJ5PSIzNTAiIGZpbGw9InVybCgjaGFsbykiLz4NCiAgPHBhdGggZD0iTTAgNzg5cTE4My03NyAzOTEgN3Q0MDktMjd2MjMxSDBaIiBmaWxsPSIjMTExMjFhIi8+DQogIDxwYXRoIGQ9Ik0xNzIgMTAwMHE0Ni0xOTYgMTY0LTI2MGw5MS0zOSAxMDIgNTJxMTI0IDc1IDE1OCAyNDdaIiBmaWxsPSIjMzYyODM5Ii8+DQogIDxwYXRoIGQ9Ik0zMTIgNDE5cS0xMC0xNjYgODItMjIwIDExNi02NyAyMDEgMjMgNjAgNjMgMzcgMjA3LTI1IDE0OC0xNDUgMTYxLTEwMS05LTEzOS0xNzFaIiBmaWxsPSJ1cmwoI3NraW4pIi8+DQogIDxwYXRoIGQ9Ik0yODYgNDQ2cS0zMC0xNzYgNzAtMjUwIDEwNi04MCAyMTItOCA3MCA0NyA2NSAyMzVsLTUwLTEwMHEtODEgMTItMTM3LTYxLTM4IDgwLTEzOSA5MVoiIGZpbGw9IiMxNzE0MWMiLz4NCiAgPHBhdGggZD0iTTM0NCA0NjNxMjcgMTAgNTAgMG03OCAwcTI2IDkgNDktMSIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjM2QyODJkIiBzdHJva2Utd2lkdGg9IjEwIiBzdHJva2UtbGluZWNhcD0icm91bmQiLz4NCiAgPHBhdGggZD0iTTQyOSA1MjBxMTcgMTEgMzQtMSIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjNjg0ODQ2IiBzdHJva2Utd2lkdGg9IjgiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPg0KICA8cGF0aCBkPSJNMzYzIDU5NHE2MCAzNiAxMTkgMCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjODE0ODUxIiBzdHJva2Utd2lkdGg9IjEwIiBzdHJva2UtbGluZWNhcD0icm91bmQiLz4NCiAgPHBhdGggZD0iTTIxNCAxMDAwcTY1LTE3NyAxNjItMjA3bC0zOCAyMDdabTQwOSAwcS01Ny0xNzQtMTY1LTIwN2w0MCAyMDdaIiBmaWxsPSIjNGEzMzQ4Ii8+DQogIDxjaXJjbGUgY3g9IjM3MCIgY3k9IjQ3OCIgcj0iNiIgZmlsbD0iI2U1YzdhNyIvPjxjaXJjbGUgY3g9IjUxOCIgY3k9IjQ3OCIgcj0iNiIgZmlsbD0iI2U1YzdhNyIvPg0KICA8cGF0aCBkPSJNOTIgMTMwdjcyMG02MTYtNjgwdjUxMCIgc3Ryb2tlPSIjZTg3OWE2IiBzdHJva2Utb3BhY2l0eT0iLjMyIiBzdHJva2Utd2lkdGg9IjIiLz4NCjwvc3ZnPg0K",
    7: "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA4MDAgMTAwMCIgcm9sZT0iaW1nIiBhcmlhLWxhYmVsbGVkYnk9InRpdGxlIj4NCiAgPHRpdGxlIGlkPSJ0aXRsZSI+U2lsaG91ZXR0ZSBpbGx1c3Ryw6llIGVudHJlIHZlcnQgcHJvZm9uZCBldCBjdWl2cmU8L3RpdGxlPg0KICA8ZGVmcz4NCiAgICA8bGluZWFyR3JhZGllbnQgaWQ9ImJhY2siIHgxPSIuMTUiIHkxPSIwIiB4Mj0iLjkiIHkyPSIxIj48c3RvcCBzdG9wLWNvbG9yPSIjMTYyYjI2Ii8+PHN0b3Agb2Zmc2V0PSIuNDgiIHN0b3AtY29sb3I9IiMxNzFiMjAiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiMzMzI1MWYiLz48L2xpbmVhckdyYWRpZW50Pg0KICAgIDxyYWRpYWxHcmFkaWVudCBpZD0iaGFsbyI+PHN0b3Agc3RvcC1jb2xvcj0iIzcwYTc3ZSIgc3RvcC1vcGFjaXR5PSIuNDkiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiM3MGE3N2UiIHN0b3Atb3BhY2l0eT0iMCIvPjwvcmFkaWFsR3JhZGllbnQ+DQogICAgPGxpbmVhckdyYWRpZW50IGlkPSJza2luIj48c3RvcCBzdG9wLWNvbG9yPSIjY2E5Yjc2Ii8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjODA1ODU0Ii8+PC9saW5lYXJHcmFkaWVudD4NCiAgPC9kZWZzPg0KICA8cmVjdCB3aWR0aD0iODAwIiBoZWlnaHQ9IjEwMDAiIGZpbGw9InVybCgjYmFjaykiLz4NCiAgPGVsbGlwc2UgY3g9IjU4MCIgY3k9IjMyMiIgcng9IjI4MCIgcnk9IjM1MCIgZmlsbD0idXJsKCNoYWxvKSIvPg0KICA8cGF0aCBkPSJNMCA4MDNxMjE3LTk4IDQxNi0xMnQzODQtNDN2MjUySDBaIiBmaWxsPSIjMTAxNTE1Ii8+DQogIDxwYXRoIGQ9Ik0xNzYgMTAwMHE0NC0xOTUgMTU3LTI2M2wxMDUtNDMgMTA2IDUxcTEzMCA3NyAxNTUgMjU1WiIgZmlsbD0iIzI5MzQzMSIvPg0KICA8cGF0aCBkPSJNMzA5IDQyMHEtMTQtMTY5IDc1LTIyNCAxMDYtNjYgMTk5IDEyIDc0IDYxIDQ3IDIyMC0yNSAxNDUtMTQ2IDE2MS0xMDEtMTAtMTM5LTE2OVoiIGZpbGw9InVybCgjc2tpbikiLz4NCiAgPHBhdGggZD0iTTI4NCA0NDFxLTI2LTE3NiA2NS0yNDcgMTE0LTg4IDIxNy02IDcwIDU2IDYzIDIzNWwtNTAtOTZxLTc3IDE0LTEzMi02Mi00MiA4MS0xMzggOTFaIiBmaWxsPSIjMTMxODE2Ii8+DQogIDxwYXRoIGQ9Ik0zNDAgNDY0cTI5IDggNTEgMG03NiAwcTI2IDggNTAgMCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjMzMyNTJhIiBzdHJva2Utd2lkdGg9IjEwIiBzdHJva2UtbGluZWNhcD0icm91bmQiLz4NCiAgPHBhdGggZD0iTTQyNiA1MjBxMTYgMTIgMzUgMCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjNWU0MDNkIiBzdHJva2Utd2lkdGg9IjgiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPg0KICA8cGF0aCBkPSJNMzU5IDU5NHE2NSAzNyAxMjYgMCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjNzA0MjRhIiBzdHJva2Utd2lkdGg9IjEwIiBzdHJva2UtbGluZWNhcD0icm91bmQiLz4NCiAgPHBhdGggZD0iTTIxMyAxMDAwcTYwLTE4MSAxNjMtMjA3bC0zOSAyMDdabTQxNyAwcS01OC0xNzUtMTY5LTIwN2w0MyAyMDdaIiBmaWxsPSIjM2M0OTQwIi8+DQogIDxjaXJjbGUgY3g9IjM2NyIgY3k9IjQ3OCIgcj0iNiIgZmlsbD0iI2RkYzNhMSIvPjxjaXJjbGUgY3g9IjUxNiIgY3k9IjQ3OCIgcj0iNiIgZmlsbD0iI2RkYzNhMSIvPg0KICA8cGF0aCBkPSJNOTcgMTkyaDN2NTIwaC0zem02MDQtOTRoM3Y2ODJoLTN6IiBmaWxsPSIjYzlhMjRiIiBvcGFjaXR5PSIuMzUiLz4NCjwvc3ZnPg0K",
    8: "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA4MDAgMTAwMCIgcm9sZT0iaW1nIiBhcmlhLWxhYmVsbGVkYnk9InRpdGxlIj4NCiAgPHRpdGxlIGlkPSJ0aXRsZSI+UG9ydHJhaXQgZ3JhcGhpcXVlIGF1eCByZWZsZXRzIGJsZXUgYXJkb2lzZSBldCB0dXJxdW9pc2U8L3RpdGxlPg0KICA8ZGVmcz4NCiAgICA8bGluZWFyR3JhZGllbnQgaWQ9ImJhY2siIHgxPSIwIiB5MT0iMCIgeDI9IjEiIHkyPSIxIj48c3RvcCBzdG9wLWNvbG9yPSIjMTYyNDJlIi8+PHN0b3Agb2Zmc2V0PSIuNTUiIHN0b3AtY29sb3I9IiMxNTE5MjMiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiMxZDJlMzUiLz48L2xpbmVhckdyYWRpZW50Pg0KICAgIDxyYWRpYWxHcmFkaWVudCBpZD0iaGFsbyI+PHN0b3Agc3RvcC1jb2xvcj0iIzY3YjhiNCIgc3RvcC1vcGFjaXR5PSIuNSIvPjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iIzY3YjhiNCIgc3RvcC1vcGFjaXR5PSIwIi8+PC9yYWRpYWxHcmFkaWVudD4NCiAgICA8bGluZWFyR3JhZGllbnQgaWQ9InNraW4iIHgyPSIuOCIgeTI9IjEiPjxzdG9wIHN0b3AtY29sb3I9IiNkN2FhODYiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiM4YjYyNWQiLz48L2xpbmVhckdyYWRpZW50Pg0KICA8L2RlZnM+DQogIDxyZWN0IHdpZHRoPSI4MDAiIGhlaWdodD0iMTAwMCIgZmlsbD0idXJsKCNiYWNrKSIvPg0KICA8ZWxsaXBzZSBjeD0iMjgwIiBjeT0iMzE1IiByeD0iMzIwIiByeT0iMzU4IiBmaWxsPSJ1cmwoI2hhbG8pIi8+DQogIDxwYXRoIGQ9Ik0wIDc5NnExOTgtODggNDA1LTh0Mzk1LTQxdjI1M0gwWiIgZmlsbD0iIzEwMTUxYiIvPg0KICA8cGF0aCBkPSJNMTcxIDEwMDBxNDktMTg5IDE2NC0yNjNsOTktNDAgMTEwIDU0cTEzMCA3OCAxNTMgMjQ5WiIgZmlsbD0iIzI2MzY0MCIvPg0KICA8cGF0aCBkPSJNMzA3IDQyMXEtMTMtMTYzIDc4LTIxOCAxMDgtNjggMTk4IDEzIDczIDY2IDQ2IDIyMC0yNSAxNDUtMTQ1IDE1Ny0xMDEtOS0xMzgtMTcyWiIgZmlsbD0idXJsKCNza2luKSIvPg0KICA8cGF0aCBkPSJNMjgyIDQ0MnEtMjgtMTc0IDY2LTI0NiAxMDgtODEgMjEyLTUgNzMgNTMgNjUgMjM0bC00OC05N3EtODIgMTQtMTM3LTYxLTM5IDgwLTEzOSA5MVoiIGZpbGw9IiMxMjE3MWQiLz4NCiAgPHBhdGggZD0iTTMzOSA0NjRxMjggOCA1MSAwbTc2IDBxMjYgOCA1MCAwIiBmaWxsPSJub25lIiBzdHJva2U9IiMzNTI2MmEiIHN0cm9rZS13aWR0aD0iMTAiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPg0KICA8cGF0aCBkPSJNNDI3IDUyMHExNyAxMSAzNSAwIiBmaWxsPSJub25lIiBzdHJva2U9IiM2NDQ3NDQiIHN0cm9rZS13aWR0aD0iOCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+DQogIDxwYXRoIGQ9Ik0zNjAgNTkzcTYzIDM3IDEyNCAwIiBmaWxsPSJub25lIiBzdHJva2U9IiM3NzQ3NGMiIHN0cm9rZS13aWR0aD0iMTAiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPg0KICA8cGF0aCBkPSJNMjE1IDEwMDBxNjUtMTc4IDE2MS0yMDlsLTM4IDIwOVptNDA5IDBxLTU2LTE3OC0xNjUtMjA4bDQxIDIwOFoiIGZpbGw9IiMzNzQ3NTIiLz4NCiAgPGNpcmNsZSBjeD0iMzY2IiBjeT0iNDc4IiByPSI2IiBmaWxsPSIjZGVjNGE0Ii8+PGNpcmNsZSBjeD0iNTE2IiBjeT0iNDc4IiByPSI2IiBmaWxsPSIjZGVjNGE0Ii8+DQogIDxwYXRoIGQ9Ik0xMDQgMTM4aDN2NzAwaC0zem02MDQgNDRoM3Y1ODBoLTN6IiBmaWxsPSIjN2RjOGJkIiBvcGFjaXR5PSIuMzMiLz4NCjwvc3ZnPg0K",
};

const $ = (s) => document.querySelector(s);
const fmt = (n) => n.toLocaleString("fr-FR");
const toast = (msg) => {
    const t = $("#toast");
    t.textContent = msg;
    t.classList.add("show");
    clearTimeout(toast.id);
    toast.id = setTimeout(() => t.classList.remove("show"), 2200);
};

/* Gallery */
const imgs = [1, 2, 3, 4, 5].map((n) => IMG[n]);
let cur = 0;
function gallery() {
    $("#gMain").src = imgs[cur];
    $("#gCount").textContent = `${cur + 1} / ${imgs.length}`;
    $("#gTiles").innerHTML = imgs
        .map((s, i) =>
            i === cur
                ? ""
                : `<button data-i="${i}" aria-label="Voir la photo ${i + 1}"><img src="${s}" alt="" loading="lazy"></button>`,
        )
        .join("");
}
$("#gTiles").addEventListener("click", (e) => {
    const b = e.target.closest("button");
    if (b) {
        cur = +b.dataset.i;
        gallery();
    }
});
$("#gPrev").onclick = () => {
    cur = (cur + imgs.length - 1) % imgs.length;
    gallery();
};
$("#gNext").onclick = () => {
    cur = (cur + 1) % imgs.length;
    gallery();
};
gallery();

/* About: read more */
const moreBtn = $("#more");

if (moreBtn) {
    moreBtn.onclick = (e) => {
        const open = $("#about").classList.toggle("open");
        $("#lessText").style.display = open ? "inline" : "none";
        $("#dots").style.display = open ? "none" : "inline";
        $("#about").style.textOverflow = open ? "clip" : "none";
        e.currentTarget.textContent = open ? "Réduire" : "Lire la suite";
        e.currentTarget.setAttribute("aria-expanded", open);
    };
}

/* Autres annonces : grille simple + filtre par quartier */
const L = [
    {
        n: "Naya Lumière",
        q: "Bonapriso",
        p: 18000,
        t: "OR",
        on: 1,
        img: 2,
        video: 0,
    },
    {
        n: "Mina Douce",
        q: "Bonanjo",
        p: 15000,
        t: "ARGENT",
        on: 1,
        img: 3,
        video: 0,
    },
    { n: "Lys d’Akwa", q: "Akwa", p: 20000, t: "OR", on: 0, img: 4, video: 1 },
    { n: "Ébène", q: "Makepe", p: 12000, t: "ARGENT", on: 1, img: 5, video: 0 },
    {
        n: "Rose du Wouri",
        q: "Bonapriso",
        p: 25000,
        t: "OR",
        on: 1,
        img: 6,
        video: 1,
    },
    {
        n: "Sérénité",
        q: "Bonanjo",
        p: 16000,
        t: "ARGENT",
        on: 0,
        img: 7,
        video: 0,
    },
    {
        n: "Douce Escale",
        q: "Akwa",
        p: 22000,
        t: "OR",
        on: 1,
        img: 8,
        video: 0,
    },
    {
        n: "Lune d’Akwa",
        q: "Akwa",
        p: 14000,
        t: "ARGENT",
        on: 1,
        img: 1,
        video: 1,
    },
];
const quartiers = [
    ["Douala", 128],
    ["Bonapriso", 24],
    ["Bonanjo", 18],
    ["Akwa", 32],
    ["Makepe", 16],
];
let filter = "Douala";

function renderChips() {
    $("#chips").innerHTML = quartiers
        .map(
            ([q, c]) =>
                `<button class="chip" aria-pressed="${q === filter}" data-q="${q}">${q === "Douala" ? "Tous" : q}<b>${c}</b></button>`,
        )
        .join("");
}
function renderGrid() {
    const list = L.filter((l) => filter === "Douala" || l.q === filter);
    $("#count").textContent =
        `${list.length} annonce${list.length > 1 ? "s" : ""} affichée${list.length > 1 ? "s" : ""}`;
    $("#grid").innerHTML = list.length
        ? list
            .map(
                (l) => `
    <a class="gcard" href="#">
      <span class="gimg"><img src="${IMG[l.img]}" alt="Portrait de ${l.n}" loading="lazy"><em class="gt">${l.t}</em>${l.on ? '<em class="go"><i></i>En ligne</em>' : ""}</span>
      <b>${l.n}</b><small>${l.q}${l.video ? " · Vidéo" : ""}</small>
      <span class="gp">${fmt(l.p)} <small>FCFA</small></span>
    </a>`,
            )
            .join("")
        : '<p class="empty">Aucune annonce dans ce quartier pour le moment.</p>';
}
$("#chips").addEventListener("click", (e) => {
    const b = e.target.closest(".chip");
    if (!b) return;
    filter = b.dataset.q;
    renderChips();
    renderGrid();
});
renderChips();
renderGrid();

/* Avis (exemples) : 2 avis à la fois, pagination */
const esc = (s) =>
    s.replace(
        /[&<>"']/g,
        (c) =>
            ({
                "&": "&amp;",
                "<": "&lt;",
                ">": "&gt;",
                '"': "&quot;",
                "'": "&#39;",
            })[c],
    );
const stars = (r) =>
    `<span class="stars" role="img" aria-label="${r} sur 5">${"★".repeat(r)}${"☆".repeat(5 - r)}</span>`;
const dist = { 5: 27, 4: 7, 3: 1, 2: 1, 1: 0 };
const reviews = [
    {
        n: "Moïse K.",
        d: "il y a 3 jours",
        r: 5,
        t: "Échange très respectueux et réponse rapide sur WhatsApp. Les photos correspondent bien à l’annonce.",
    },
    {
        n: "Ludovic T.",
        d: "il y a 1 semaine",
        r: 5,
        t: "Ponctuelle et discrète, tout s’est passé comme convenu.",
    },
    {
        n: "Brice N.",
        d: "il y a 2 semaines",
        r: 4,
        t: "Bonne communication. Léger retard sur l’horaire, mais prévenu à l’avance.",
    },
    {
        n: "Kevin M.",
        d: "il y a 3 semaines",
        r: 5,
        t: "Très professionnelle, l’échange sur WhatsApp était clair du début à la fin.",
    },
    {
        n: "Arnaud D.",
        d: "il y a 1 mois",
        r: 5,
        t: "Accueil agréable et lieu conforme à la description.",
    },
    {
        n: "Patrick E.",
        d: "il y a 1 mois",
        r: 4,
        t: "Rien à redire sur le respect et la discrétion. Je recommande.",
    },
];
const tints = ["var(--blue)", "var(--pink)", "var(--yellow)"];
const PER = 2;
let revPage = 0;
function renderReviews() {
    const total = Object.values(dist).reduce((a, b) => a + b, 0);
    const avg =
        Object.entries(dist).reduce((a, [k, v]) => a + k * v, 0) / total;
    const avgTxt = avg.toFixed(1).replace(".", ",");
    $("#revSum").innerHTML = `
    <div class="rs-top"><b>${avgTxt}</b><span>sur 5</span></div>
    ${stars(Math.round(avg))}
    <p class="sm">${total} avis</p>
    <ul class="dist">${[5, 4, 3, 2, 1].map((k) => `<li><span>${k}</span><i style="--w:${Math.round((dist[k] / total) * 100)}%"></i><b>${dist[k]}</b></li>`).join("")}</ul>`;
    const pages = Math.max(1, Math.ceil(reviews.length / PER));
    revPage = Math.min(revPage, pages - 1);
    const start = revPage * PER;
    $("#revList").innerHTML = reviews
        .slice(start, start + PER)
        .map(
            (r, i) => `
    <article class="rev">
      <div class="rev-top"><span class="rev-av" style="background:${tints[(start + i) % 3]}">${esc(r.n[0].toUpperCase())}</span><div><b>${esc(r.n)}</b><small>${r.d}</small></div>${stars(r.r)}</div>
      <p>${esc(r.t)}</p>
    </article>`,
        )
        .join("");
    $("#revPager").hidden = pages < 2;
    $("#revPage").textContent = `${revPage + 1} / ${pages}`;
    $("#revPrev").disabled = revPage === 0;
    $("#revNext").disabled = revPage >= pages - 1;
    document
        .querySelectorAll("[data-avg]")
        .forEach((n) => (n.textContent = avgTxt));
    document
        .querySelectorAll("[data-total]")
        .forEach((n) => (n.textContent = total));
}
renderReviews();
$("#revPrev").onclick = () => {
    revPage--;
    renderReviews();
};
$("#revNext").onclick = () => {
    revPage++;
    renderReviews();
};
const closeForm = () => {
    $("#revForm").hidden = true;
    $("#revBtn").setAttribute("aria-expanded", false);
    $("#revBtn").focus();
};
$("#revClose").onclick = closeForm;
$("#revCancel").onclick = () => {
    $("#revForm").reset();
    closeForm();
};
$("#revBtn").onclick = (e) => {
    const f = $("#revForm");
    f.hidden = !f.hidden;
    e.currentTarget.setAttribute("aria-expanded", !f.hidden);
    if (!f.hidden) f.elements.text.focus();
};
$("#revForm").addEventListener("submit", (e) => {
    e.preventDefault();
    const f = e.target,
        r = +f.elements.rating.value,
        t = f.elements.text.value.trim();
    if (t.length < 10) return;
    dist[r]++;
    reviews.unshift({
        n: f.elements.author.value.trim() || "Anonyme",
        d: "à l’instant",
        r,
        t,
    });
    f.reset();
    f.hidden = true;
    $("#revBtn").setAttribute("aria-expanded", false);
    revPage = 0;
    renderReviews();
    toast("Merci pour votre avis");
});

/* Favorite, share, report */
let likes = document.querySelectorAll("[data-likes]")[0].textContent | 0,
    faved = false;
function toggleFav() {
    faved = !faved;
    likes += faved ? 1 : -1;
    ["#fav", "#favFloat"].forEach((s) =>
        $(s).setAttribute("aria-pressed", faved),
    );
    document
        .querySelectorAll("[data-likes]")
        .forEach((n) => (n.textContent = likes));
    toast(faved ? "Ajoutée à vos favoris" : "Retirée de vos favoris");
}
$("#fav").onclick = toggleFav;
$("#favFloat").onclick = toggleFav;
$("#share").onclick = async () => {
    const data = { title: document.title, url: location.href };
    try {
        if (navigator.share) await navigator.share(data);
        else {
            await navigator.clipboard.writeText(data.url);
            toast("Lien copié");
        }
    } catch {
        /* partage annulé */
    }
};
$("#report").onclick = () => toast("Merci, votre signalement a été envoyé");

/* Portrait du héros */
document.querySelectorAll("[data-img]").forEach((i) => {
    i.src = IMG[i.dataset.img];
});

/* Semaine en cours (aujourd'hui en noir) */
(() => {
    const now = new Date(),
        mon = new Date(now);
    mon.setDate(now.getDate() - ((now.getDay() + 6) % 7));
    const names = ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"];
    $("#week").innerHTML = names
        .map((n, i) => {
            const d = new Date(mon);
            d.setDate(mon.getDate() + i);
            const today = d.toDateString() === now.toDateString();
            return `<span class="${today ? "today" : ""}"${today ? ' aria-current="date"' : ""}>${n}<b>${d.getDate()}</b></span>`;
        })
        .join("");
})();

/* Discussion rapide */
const chat = $("#chat"),
    launch = $("#chatOpen");
const setChat = (open) => {
    chat.hidden = !open;
    launch.setAttribute("aria-expanded", open);
};
launch.onclick = () => setChat(chat.hidden);
$("#toolChat").onclick = () => setChat(chat.hidden);
$("#chatX").onclick = () => setChat(false);
document.addEventListener("keydown", (e) => {
    if (e.key !== "Escape") return;
    setChat(false);
    if (!$("#revForm").hidden) closeForm();
});
