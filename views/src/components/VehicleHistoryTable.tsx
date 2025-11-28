import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { History, Trash2 } from "lucide-react";
import { Vehicle } from "@/services/api";
import { format } from "date-fns";
import { ptBR } from "date-fns/locale";
import Swal from "sweetalert2";

interface VehicleHistoryTableProps {
  vehicles: Vehicle[];
  onDelete: (id: number) => void;
}

export const VehicleHistoryTable = ({ vehicles, onDelete }: VehicleHistoryTableProps) => {
  const handleDelete = async (id: number, plate: string) => {
    const result = await Swal.fire({
      title: "Confirmar exclusão?",
      text: `Deseja remover o veículo ${plate} do histórico?`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Sim, excluir",
      cancelButtonText: "Cancelar",
      confirmButtonColor: "#ef4444",
    });

    if (result.isConfirmed) {
      onDelete(id);
    }
  };

  const leftVehicles = vehicles.filter(v => v.status === 'left');

  return (
    <Card>
      <CardHeader>
        <CardTitle className="flex items-center gap-2">
          <History className="h-5 w-5" />
          Histórico de Veículos
        </CardTitle>
        <CardDescription>
          {leftVehicles.length} {leftVehicles.length === 1 ? "registro" : "registros"} de saída
        </CardDescription>
      </CardHeader>
      <CardContent>
        {leftVehicles.length === 0 ? (
          <div className="flex flex-col items-center justify-center py-12 text-center">
            <History className="h-12 w-12 text-muted-foreground mb-4" />
            <p className="text-muted-foreground">Nenhum registro no histórico</p>
          </div>
        ) : (
          <div className="rounded-md border">
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>Placa</TableHead>
                  <TableHead>Modelo</TableHead>
                  <TableHead>Entrada</TableHead>
                  <TableHead>Saída</TableHead>
                  <TableHead className="text-right">Valor</TableHead>
                  <TableHead className="text-right">Ações</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {leftVehicles.map((vehicle) => (
                  <TableRow key={vehicle.id}>
                    <TableCell>
                      <Badge variant="outline" className="font-mono">
                        {vehicle.plate}
                      </Badge>
                    </TableCell>
                    <TableCell>{vehicle.model}</TableCell>
                    <TableCell className="text-sm text-muted-foreground">
                      {format(new Date(vehicle.entryTime), "dd/MM/yy HH:mm", { locale: ptBR })}
                    </TableCell>
                    <TableCell className="text-sm text-muted-foreground">
                      {vehicle.exitTime 
                        ? format(new Date(vehicle.exitTime), "dd/MM/yy HH:mm", { locale: ptBR })
                        : "-"
                      }
                    </TableCell>
                    <TableCell className="text-right font-medium">
                      {vehicle.price 
                        ? `R$ ${vehicle.price.toFixed(2)}`
                        : "-"
                      }
                    </TableCell>
                    <TableCell className="text-right">
                      <Button
                        variant="ghost"
                        size="icon"
                        onClick={() => handleDelete(vehicle.id, vehicle.plate)}
                      >
                        <Trash2 className="h-4 w-4 text-destructive" />
                      </Button>
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </div>
        )}
      </CardContent>
    </Card>
  );
};
