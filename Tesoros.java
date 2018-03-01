import java.util.Random;
import java.util.List;
import java.util.ArrayList;

public class Tesoros {


	public static void main(String[] args) {
		
		int tipo = 0;
		
		if (args.length == 1) {
			tipo = new Integer(args[0]);
		}
		else{
			System.out.println("Modo de Uso:");
			System.out.println(">java Tesoros tipo");
			System.out.println("tipo 1: Guarida Pequeña");
			System.out.println("tipo 2: Guarida Mediana");
			System.out.println("tipo 3: Guarida Grande");
			return;
		}
		
		// Generar tesoro para la guarida elegida
		// La idea es determinar primero el valor total del tesoro
		// Luego, comienzan a tirarse objetos y monedas hasta completar esa cantidad esperada
		// Dependiendo del tipo, quizas primero puedan tirarse todas las monedas
		// Los diferentes tipos estan pensados como:
		//   - Que (y cuanto) suele llevarse
		//   - Las pertenencias de cuantos contiene el tesoro
		//   - Situaciones especiales (para casos como tesoros grandes)
		
		// Consideraciones para las cantidades esperadas (primera aproximacion):
		//   - Una persona tipica quizas lleva 1d4-1 plateados en total en monedas
		//   - Ademas, puede llevar 1d6-1 plateados en objetos valiosos
		//   - Adicionalmente, quizas unos 3d6-3 plateados en equipo
		//   - Notar que parte de sus armas y equipos esten demasiado dañados para contarse
		
		// Una guarida pequeña suele consistir en las pertenences de 1d4 personas
		// Una guarida mediana quizas tenga 2d8 personas en pertenencias
		// Una guardia grande deberia tener unas 5d8 personas en pertenencias
		Tesoros t = new Tesoros();
		t.generar(tipo);
		
	}
	
	public Tesoros(){
		rand = new Random();
	}
	
	public void generar(int tipo){
		
		int n_personas = getNumPersonas(tipo);
		System.out.println("generar - n_personas: " + n_personas);
		
		// Generar monedas primero
		int[] monedas = new int[4];
		monedas[0] = 0;
		monedas[1] = 0;
		monedas[2] = 0;
		monedas[3] = 0;
		for(int i = 0; i < n_personas; ++i){
			agregarMonedas(monedas);
		}
		agruparMonedas(monedas);
		System.out.println("generar - negros: " + monedas[0]);
		System.out.println("generar - rojos: " + monedas[1]);
		System.out.println("generar - plateados: " + monedas[2]);
		System.out.println("generar - dorados: " + monedas[3]);
		
		// Generar tesoros (objetos valiosos)
		int plat_tesoros = 0;
		List<Item> tesoros = new ArrayList<Item>();
		for(int i = 0; i < n_personas; ++i){
			plat_tesoros += dado(1, 6, -2);
		}
		System.out.println("generar - plat_tesoros: " + plat_tesoros);
		while( plat_tesoros > 0 ){
			Item item;
			if( plat_tesoros > 40 ){
				item = getObjetoCostoso();
			}
			else if( plat_tesoros > 20 ){
				item = getObjetoMedio();
			}
			else{
				item = getObjetoBarato();
			}
			item.print();
			tesoros.add(item);
			plat_tesoros -= item.valor;
		}
		
		
		
	}
	
	public int getNumPersonas(int tipo){
		if( tipo == 1 ){
			System.out.println("getNumPersonas - Guarida Pequeña");
			return dado(1, 4);
		}
		else if( tipo == 2 ){
			System.out.println("getNumPersonas - Guarida Media");
			return dado(2, 8);
		}
		else if( tipo == 3 ){
			System.out.println("getNumPersonas - Guarida Grande");
			return dado(8, 8);
		}
		else{
			System.out.println("getNumPersonas - Tipo Desconocido");
			return 0;
		}
	}
	
	public void agregarMonedas(int[] monedas){
		monedas[0] += dado(1, 10, -2);
		monedas[1] += dado(1, 6, -2);
		monedas[2] += dado(1, 4, -2);
	}
	
	public void agruparMonedas(int[] monedas){
		if( monedas[0] > 20 ){
			monedas[1] += (monedas[0]/20);
			monedas[0] -= 10 * (monedas[0]/20);
		}
		if( monedas[1] > 20 ){
			monedas[2] += (monedas[1]/20);
			monedas[1] -= 10 * (monedas[1]/20);
		}
		if( monedas[2] > 20 ){
			monedas[3] += (monedas[2]/20);
			monedas[2] -= 10 * (monedas[2]/20);
		}
	}
	
	public Item getObjetoBarato(){
		int pos = rand.nextInt(gemas_baratas.length);
		Item i = new Item();
		i.nombre = gemas_baratas[pos][0];
		i.descripcion = gemas_baratas[pos][1];
		i.valor = dado(1, 8);
		return i;
	}
	
	public Item getObjetoMedio(){
		int pos = rand.nextInt(gemas_medias.length);
		Item i = new Item();
		i.nombre = gemas_medias[pos][0];
		i.descripcion = gemas_medias[pos][1];
		i.valor = dado(3, 8);
		return i;
	}
	
	public Item getObjetoCostoso(){
		int pos = rand.nextInt(gemas_costosas.length);
		Item i = new Item();
		i.nombre = gemas_costosas[pos][0];
		i.descripcion = gemas_costosas[pos][1];
		i.valor = dado(8, 8);
		return i;
	}
	
	public int dado(int num, int caras, int mod){
		int total = dado(num, caras);
		total += mod;
		if(total < 0){
			total = 0;
		}
		return total;
	}
	
	public int dado(int num, int caras){
		int total = 0;
		for(int i = 0; i < num; ++i){
			total += (1 + rand.nextInt(caras));
		}
		return total;
	}
	
	public class Item{
		String nombre;
		String descripcion;
		int valor;
		public void print(){
			System.out.println("Item: " + nombre + " (" + valor + " plat)");
		}
	}
	
	Random rand;
	
	static String[][] gemas_baratas = {
		{"Cuarzo Blanco", "Pequeña piedra blanquecina"}, 
		{"Cuarzo Rosa", "Piedra rosa translúcida"}, 
		{"Cuarzo Azul", "Pequeña gema azulada"}, 
		{"Ambar", "Gema color caramelo"}, 
		{"Ambar con Hoja", "Pequeña gema amarillenta con una hoja en su interior"}, 
		{"Perla", "Perla blanca grisásea"}, 
		{"Brillante", "Pequeña piedra transparente"}, 
		{"Pequeño Rubi", "Pequeña piedra rojo brillante"}, 
		{"Pequeña Esmeralda", "Pequeña piedra verdosa traslúcida"}, 
		{"Pequeño Zafiro", "Pequeña piedra azúl oscuro"}, 
		{"Pequeño Topacio", "Pequeño cristal amarillo brillante"}, 
		{"Aguamarina", "Gema celeste lechosa"}, 
		{"Pequeño Ópalo", "Pequeña piedra lechosa con brillos tornasol"},
		{"Diamante en Bruto", "Gema traslúcida y brillante pero sin cortar"},  
		{"Onix", "Pequeña piedra redondeada negra brillante"}, 
		{"Obsidiana", "Piedra negra traslúcida"}, 
		{"Lapislazuli", "Piedra azulada con toques grises"}, 
		{"Turquesa", "Piedra brillante celeste con toques verdosos"}, 
		{"Circón", "Piedra anaranjada con vetas amarillentas"}, 
		{"Trozo de Jade", "Pequeña piedra verde lechosa"}
	};
	
	static String[][] gemas_medias = {
		{"Ambar Grande", "Gema de gran tamaño naranjo rojizo"}, 
		{"Amatista", "test"}, 
		{"Coral", "test"}, 
		{"Granate", "test"}, 
		{"Jade", "test"}, 
		{"Perla Negra", "test"}, 
		{"Topacio", "test"}, 
		{"Rubi", "test"}, 
		{"Ópalo", "test"}, 
		{"Zafiro", "test"}, 
		{"3 Cuarzos Blancos", "Bolsita de tela negra con 3 piedras blancas en su interior"}, 
		{"Figurlla de Jade", "Pequeña figura de la cabeza de un caballo de una piedra verde"}
	};
	
	static String[][] gemas_costosas = {
		{"gema 1", "test"}, 
		{"gema 2", "test"}
	};
	
	
}
