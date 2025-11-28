import { useState } from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { PlusCircle } from "lucide-react";
import Swal from "sweetalert2";
import { parkingAPI } from "@/services/api";

interface VehicleEntryFormProps {
  onSuccess: () => void;
}

export const VehicleEntryForm = ({ onSuccess }: VehicleEntryFormProps) => {
  const [plate, setPlate] = useState("");
  const [vehicleType, setVehicleType] = useState("car");
  const [loading, setLoading] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    if (!plate) {
      Swal.fire({
        icon: "warning",
        title: "Campos obrigatórios",
        text: "Por favor, preencha a placa",
      });
      return;
    }

    setLoading(true);
    try {
      const vehicle = await parkingAPI.registerEntry({
        plate: plate.toUpperCase(),
        vehicleType,
      });

      Swal.fire({
        icon: "success",
        title: "Veículo registrado!",
        html: `
          <div class="text-left">
            <p><strong>Placa:</strong> ${vehicle.plate}</p>
            <p><strong>Ticket ID:</strong> ${vehicle.ticket_id}</p>
            <p class="text-sm text-muted-foreground mt-2">Guarde o número do ticket para a saída!</p>
          </div>
        `,
        timer: 5000,
        showConfirmButton: true,
      });

      setPlate("");
      setVehicleType("car");
      onSuccess();
    } catch (error) {
      Swal.fire({
        icon: "error",
        title: "Erro ao registrar",
        text: "Não foi possível registrar a entrada do veículo. Verifique se o backend está rodando.",
      });
    } finally {
      setLoading(false);
    }
  };

  return (
    <Card>
      <CardHeader>
        <CardTitle className="flex items-center gap-2">
          <PlusCircle className="h-5 w-5" />
          Registrar Entrada
        </CardTitle>
        <CardDescription>Adicione um novo veículo ao estacionamento</CardDescription>
      </CardHeader>
      <CardContent>
        <form onSubmit={handleSubmit} className="space-y-4">
          <div className="space-y-2">
            <Label htmlFor="plate">Placa</Label>
            <Input
              id="plate"
              placeholder="ABC-1234"
              value={plate}
              onChange={(e) => setPlate(e.target.value)}
              className="uppercase"
              maxLength={8}
            />
          </div>
          <div className="space-y-2">
            <Label htmlFor="vehicleType">Tipo de Veículo</Label>
            <select
              id="vehicleType"
              className="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
              value={vehicleType}
              onChange={(e) => setVehicleType(e.target.value)}
            >
              <option value="car">Carro</option>
              <option value="motorcycle">Moto</option>
            </select>
          </div>
          <Button type="submit" className="w-full" disabled={loading}>
            {loading ? "Registrando..." : "Registrar Entrada"}
          </Button>
        </form>
      </CardContent>
    </Card>
  );
};
