import json
from typing import List
from fastapi import FastAPI, UploadFile, File
from pydantic import BaseModel
from scheduler import read_data_from_json, preprocess_series, calculate_total_series_time, distribute_series_to_ovens

class OperationModel(BaseModel):
    name: str
    timing: int
    required_temp: int

class Operation(BaseModel):
    name: str
    timing: int
    required_temp: int

class Oven(BaseModel):
    start_temp: int
    working_temps: List[int]
    operations: List[OperationModel]

app = FastAPI()

@app.post("/read-data/")
async def read_data(file: UploadFile = File(...)):
    """
    Загрузка и чтение данных из JSON-файла.
    """
    content = await file.read()
    data = json.loads(content)
    ovens, series_operations = read_data_from_json(data)
    return {"message": "Data read successfully"}

@app.post("/process-series/")
async def process_series(data: List[Operation]):
    """
    Предварительная обработка серий операций.
    """
    processed_series = preprocess_series(data)
    return {"processed_series": processed_series}

@app.get("/calculate-time/{oven_id}")
async def calculate_time(oven_id: int, series: List[Operation]):
    """
    Расчет времени.
    """
    total_time = calculate_total_series_time(series, oven_id)
    return {"total_time": total_time}

@app.post("/distribute-series/")
async def distribute_series(data: List[Operation], num_ovens: int):
    """
    Распределение серий операций по печам.
    """
    ovens = ... # Создайте список объектов Oven
    oven_groups = ... # Определите группы печей
    distribution = distribute_series_to_ovens(data, ovens, oven_groups)
    return {"distribution": distribution}

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8000)
