CREATE TABLE IF NOT EXISTS boleto (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    data_vencimento TEXT NOT NULL,
    data_emissao TEXT NOT NULL,
    data_pagamento TEXT,
    valor REAL NOT NULL DEFAULT 0,
    desconto REAL NOT NULL DEFAULT 0,
    juros REAL NOT NULL DEFAULT 0,
    multa REAL NOT NULL DEFAULT 0,
    mora REAL NOT NULL DEFAULT 0,
    valor_pago REAL NOT NULL DEFAULT 0
);
