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
//		System.out.println("generar - negros: " + monedas[0]);
//		System.out.println("generar - rojos: " + monedas[1]);
//		System.out.println("generar - plateados: " + monedas[2]);
//		System.out.println("generar - dorados: " + monedas[3]);
		
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
				item = getTesoroCostoso();
			}
			else if( plat_tesoros > 20 ){
				item = getTesoroMedio();
			}
			else{
				item = getTesoroBarato();
			}
//			item.print();
			tesoros.add(item);
			plat_tesoros -= item.valor;
		}
		
		// Generar equipo y objetos varios
		int plat_equipo = 0;
		List<Item> equipo = new ArrayList<Item>();
		for(int i = 0; i < n_personas; ++i){
			plat_equipo += dado(1, 6, -2);
		}
		plat_equipo *= 1.5;
		System.out.println("generar - plat_equipo: " + plat_equipo);
		while( plat_equipo > 0 ){
			Item item;
			if( plat_equipo > 40 ){
				item = getEquipoCostoso();
			}
			else if( plat_equipo > 20 ){
				item = getEquipoModerado();
			}
			else if( plat_equipo > 10 ){
				item = getEquipoBarato();
			}
			else{
				item = getEquipoMuyBarato();
			}
//			item.print();
			equipo.add(item);
			plat_equipo -= item.valor;
		}
		
		// Escribir resultado
		System.out.println("----- Descripción General -----");
		System.out.println("");
		int intro_pos = rand.nextInt(intros.length);
		System.out.println(intros[intro_pos]);
		System.out.println("");
		for( Item i : tesoros ){
			System.out.println("\t" + i.descripcion);
		}
		System.out.println("");
		for( Item i : equipo ){
			System.out.println("\t" + i.descripcion);
		}
		System.out.println("");
		if(monedas[0] > 0 ){
			System.out.println("\t" + monedas[0] + " negros");
		}
		if(monedas[1] > 0 ){
			System.out.println("\t" + monedas[1] + " rojos");
		}
		if(monedas[2] > 0 ){
			System.out.println("\t" + monedas[2] + " plateados");
		}
		if(monedas[3] > 0 ){
			System.out.println("\t" + monedas[3] + " dorados");
		}
		System.out.println("");
		System.out.println("-----  -----");
		System.out.println("----- Descripción DM -----");
		System.out.println("");
		System.out.println(intros[intro_pos]);
		System.out.println("");
		for( Item i : tesoros ){
			System.out.println("\t" + i.nombre + " (" + i.valor + " p)");
		}
		System.out.println("");
		for( Item i : equipo ){
			System.out.println("\t" + i.nombre + " (" + i.valor + " p)");
		}
		System.out.println("");
		if(monedas[0] > 0 ){
			System.out.println("\t" + monedas[0] + " negros");
		}
		if(monedas[1] > 0 ){
			System.out.println("\t" + monedas[1] + " plateados");
		}
		if(monedas[2] > 0 ){
			System.out.println("\t" + monedas[2] + " rojos");
		}
		if(monedas[3] > 0 ){
			System.out.println("\t" + monedas[3] + " dorados");
		}
		System.out.println("");
		System.out.println("-----  -----");
		
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
	
	public Item getTesoroBarato(){
		int pos = rand.nextInt(gemas_baratas.length);
		Item i = new Item();
		i.nombre = gemas_baratas[pos][0];
		i.descripcion = gemas_baratas[pos][1];
		i.valor = dado(1, 8);
		return i;
	}
	
	public Item getTesoroMedio(){
		int pos = rand.nextInt(gemas_medias.length);
		Item i = new Item();
		i.nombre = gemas_medias[pos][0];
		i.descripcion = gemas_medias[pos][1];
		i.valor = dado(3, 8);
		return i;
	}
	
	public Item getTesoroCostoso(){
		int pos = rand.nextInt(gemas_costosas.length);
		Item i = new Item();
		i.nombre = gemas_costosas[pos][0];
		i.descripcion = gemas_costosas[pos][1];
		i.valor = dado(8, 8);
		return i;
	}
	
	public Item getEquipoMuyBarato(){
		int pos = rand.nextInt(equipo_muy_barato.length);
		Item i = new Item();
		i.nombre = equipo_muy_barato[pos][0];
		i.descripcion = equipo_muy_barato[pos][1];
		i.valor = new Integer(equipo_muy_barato[pos][2]);
		return i;
	}
	
	public Item getEquipoBarato(){
		int pos = rand.nextInt(equipo_barato.length);
		Item i = new Item();
		i.nombre = equipo_barato[pos][0];
		i.descripcion = equipo_barato[pos][1];
		i.valor = new Integer(equipo_barato[pos][2]);
		return i;
	}
	
	public Item getEquipoModerado(){
		int pos = rand.nextInt(equipo_moderado.length);
		Item i = new Item();
		i.nombre = equipo_moderado[pos][0];
		i.descripcion = equipo_moderado[pos][1];
		i.valor = new Integer(equipo_moderado[pos][2]);
		return i;
	}
	
	public Item getEquipoCostoso(){
		int pos = rand.nextInt(equipo_costoso.length);
		Item i = new Item();
		i.nombre = equipo_costoso[pos][0];
		i.descripcion = equipo_costoso[pos][1];
		i.valor = new Integer(equipo_costoso[pos][2]);
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
		{"Ambar", "Piedra de bordes suaves de color anaranjado"}, 
		{"Ambar", "Gema color caramelo"}, 
		{"Ambar con Hoja", "Pequeña gema amarillenta con una hoja en su interior"}, 
		{"Perla", "Piedra redonda y muy liviana color blanco"}, 
		{"Perla", "Perla blanca grisásea"}, 
		{"Brillante", "Pequeña piedra transparente"}, 
		{"Pequeño Rubi", "Pequeña piedra rojo brillante"}, 
		{"Pequeña Esmeralda", "Pequeña piedra verdosa traslúcida"}, 
		{"Pequeño Zafiro", "Pequeña piedra azúl oscuro"}, 
		{"Pequeño Topacio", "Pequeño cristal amarillo brillante"}, 
		{"Aguamarina", "Gema celeste lechosa"}, 
		{"Pequeño Ópalo", "Pequeña piedra lechosa con brillos tornasol"},
		{"Diamante en Bruto", "Gema traslúcida y brillante pero sin cortar"},  
		{"Ónix", "Pequeña piedra redondeada negra brillante"}, 
		{"Obsidiana", "Piedra negra traslúcida"}, 
		{"Lapislazuli", "Piedra azulada con toques grises"}, 
		{"Turquesa", "Piedra brillante celeste con toques verdosos"}, 
		{"Circón", "Piedra anaranjada con vetas amarillentas"}, 
		{"Trozo de Jade", "Pequeña piedra verde lechosa"}
	};
	
	static String[][] gemas_medias = {
		{"Ambar Grande", "Gema de gran tamaño naranjo rojizo"}, 
		{"Amatista", "Cristal púrpura oscuro"}, 
		{"Granate", "Gema de buen tamaño de color rojo muy oscuro"}, 
		{"Jade", "Piedra color verde oscuro con vetas verde claro"}, 
		{"Perla Negra", "Pequeña piedra muy liviana, color negro con brillo tornasol"}, 
		{"Topacio", "Cristal amarillo ligeramente anaranjado"}, 
		{"Rubi", "Gema con forma de gota de un color rojo sangre"}, 
		{"Ópalo", "Piedra brillante de base oscura con brillos multicolores"}, 
		{"Zafiro", "Cristal muy brillante de color azúl"}, 
		{"3 Cuarzos Blancos", "Bolsita de tela negra con 3 piedras blancas en su interior"}, 
		{"Figurlla de Jade", "Pequeña figura de la cabeza de un caballo de una piedra verde"},
		{"2 Cuarzos Blancos", "Bolsa de tela con 2 pequeñas piedras traslúcidas"}, 
		{"3 Cuarzos Rosa", "Bolsita de tela con 3 gemas ligeramente rosadas"}, 
		{"4 Cuarzos Azul", "Pequeña caja de madera con 4 pequeñas gemas azuladas"}, 
		{"3 Ambares", "Bolsita de tela con 3 gemas de un amarillo acaramelado"}, 
		{"4 Perlas", "Bolsita de tela oscura con 4 perlas blancas"}, 
		{"2 Brillantes", "Pequeño saco con 2 piedras brillantes"}, 
		{"3 Rubíes Pequeños", "Saquito de cuero con 3 pequeñas piedras rojas"}, 
		{"2 Esmeraldas Pequeñas", "Bolsa con 2 pequeñas gemas verdosas"}, 
		{"2 Zafiros Pequeños", "Bolsa con 2 piedras azules"}, 
		{"3 Topacios Pequeños", "Pequeña bolsa de género con 3 cristales amarillos"}, 
		{"2 Ópalos Pequeños", "Pequeña piedra lechosa con brillos tornasol"},
		{"3 Diamantes en Bruto", "Bolsita de género con 3 gemas sin cortar"},  
		{"3 Ónixes", "Saco pequeño de cuero con 3 piedras negras y brillantes"}, 
		{"Lapislazuli Grande", "Piedra de buen tamaño, azúl oscuro con toques blancos"}, 
		{"2 Turquesas", "Cajita de madera con 2 piedras celeste verdoso"}, 
		{"Circón Grande", "Enorme gema anaranjada rojiza"}
		
	};
	
	static String[][] gemas_costosas = {
		{"Anillo de Oro", "Anillo de metal dorado"}, 
		{"Anillo de Plata", "Anillo de metal plateado"},
		{"Anillo de Diamante", "Anillo dorado con un cristal brillante"},
		{"Anillo con Esmeralda", "Anillo dorado con una gema verdosa"},
		{"Anillo con Rubi", "Anillo plateado con una gema rojiza"},
		{"Collar de Oro", "Collar de piezas de metal dorado"},
		{"Collar de Plata", "Collar de cadena plateada"},
		{"Collar de Perlas", "Collar plateado con varias perlas"},
		{"Collar con Perla Negra", "Collar plateado con una piedra oscura muy liviana"},
		{"Collar con Rubi", "Collar dorado con cristales rojizos"},
		{"Collar con Zafiro", "Collar plateado con una gema azúl oscuro"},
		{"Pulsera de Oro", "Pulsera de metal dorado"},
		{"Pulsera de Plata", "Pulsera de metal plateado"},
		{"Pulsera con Diamantes", "Pulsera plateada con pequeñas gemas brillantes"},
		{"Broche de Oro", "Broche dorado con forma de escarabajo"},
		{"Broche de Plata", "Broche plateado con forma de flor"},
		{"Broche con Esmeraldas", "Broche plateado con gema verde"},
		{"Diadema de Oro", "Delgada diadema de metal dorado"},
		{"Diadema de Plata", "Diadema de metal plateado"},
		{"Capa Fina de Pieles", "Capa con el cuello cubierto de suaves pieles"},
		{"Capa con Hilos Dorados", "Hermosa capa oscura decorada con hilos dorados"},
		{"Guantes Finos de Piel", "Guantes de cuero con suaves pieles en las muñecas"},
		{"Gauntes de Piel Exótica", "Guantes de un extraño cuero azul brillante"},
		{"Citurón con Hebilla de Oro", "Cinturón de cuero oscuro con la hebilla de metal dorado"},
		{"Botas con Hebillas de Plata", "Botas suaves con varias hebillas de metal plateado"},
		{"Daga de Oro", "Pequeña daga de metal dorado con grabados antiguos"},
		{"Daga de Plata", "Daga de metal plateado y brillante"},
		{"Daga con Brillantes", "Daga con incrustaciones de pequeños cristales"},
		{"Amatista Grande", "Enorme cristal púrpura"}, 
		{"Granate Grande", "Gema del porte de un puño, rojo anaranjado"}, 
		{"4 Perla Negra", "Bolsita de cuero con 4 perlas oscuras y brillantes"}, 
		{"Topacio Grande", "Cristal grande color amarillo anaranjado"}, 
		{"Rubi Grande", "Enorme gema muy brillante de color rojo oscuro"}, 
		{"Zafiro Grande", "Gran cristal color azúl profundo"}, 
		{"Collar de Jade", "Collar de placas de una piedra verde opaco"},
		{"Figura de Jade", "Detallada figurilla de un arbol, de piedra verdosa"},
		{"Figura de Lapislazuli", "Figura de un felino de piedra azúl con toques oscuros"},
		{"Figura de Lapislazuli", "Figurilla de un animal marino de piedra azúl oscuro"},
		{"Figura de Oro", "Figura metálica dorada simbolizando el Sol"},
		{"Figura de Oro", "Figurilla de un guerrero de metal dorado"},
		{"Figura de Plata", "Figura metálica plateada simbolizando la Luna"},
		{"Figura de Plata", "Figurilla de un animal de metal plateado"},
		{"Hacha de Oro", "Hacha ceremonial de metal dorado"}
	};
	
	static String[] intros = {
		"Entre los restos encuentran los siguientes objetos: ",
		"Entremedio de los restos pueden encontrar los siguientes objetos: ",
		"Entre restos y trozos logran hallar los siguientes artículos: ",
		"Los objetos de interes encontrados son los que siguen: ",
		"Los pocos objetos de valor encontrados son estos: ",
		"Luego de hurgar entre los despojos pudieron reunir los siguientes objetos de valor. ",
		"Aunque la mayoría de los objetos estan dañados, se las arreglaron para encontrar lo siguiente.",
		"Encontraron los siguientes objetos de valor, aunque algo sucios y mohosos.",
		"Entre raíces, huesos y restos pudieron encontrar lo siguiente.",
		"Los únicos objetos valiosos que puedieron reunir son los que siguen.",
		"Algunos de los objetos que vieron en el lugar eran de valor.",
		"Los únicos objetos de interes en el lugar fueron los siguientes:",
		"Luego de buscar un buen rato, puedieron reunir un pequeño grupo de objetos valiosos.",
		"Buscaron tesoros y cualquier objeto útil en el lugar, lograron reunir lo siguiente.",
		"Aunque esperavan encontrar un tesoro, solo hallaron los siguientes objetos útiles.",
		"Entre los restos, pudieron encontrar algunas monedas y objetos valiosos.",
		"Las únicas monedas y objetos de valor encontrados fueron los siguientes.",
		"Los objetos encontrados y valiosos fueron los siguientes.",
		"Algunos objetos estan algo dañados para ser recuperados, pero al menos pudieron encontrar lo siguiente.",
		"Las posesiones de valor encontradas en el lugar son las siguientes.",
		"Los principales objetos de interes son: "
	};
	
	static String[][] equipo_muy_barato = {
		{"Daga", "Daga", "5"},
		{"Daga", "Daga", "5"},
		{"Puñal", "Puñal", "7"},
		{"Lanza", "Lanza", "7"},
		{"Lanza", "Lanza", "7"},
		{"Venablo", "Venablo", "5"},
		{"Voulge", "Voulge", "8"},
		{"Garrote de Guerra", "Garrote de Guerra", "5"},
		{"Hacha de Mano", "Hacha de Mano", "6"},
		{"Hoz", "Hoz", "6"},
		{"Yelmo de Cuero", "Yelmo de Cuero", "5"},
		{"Yelmo de Cuero", "Yelmo de Cuero", "5"},
		{"4 Antorchas", "4 Antorchas", "1"},
		{"Candado", "Candado", "5"},
		{"Cuerda", "Cuerda", "1"},
		{"Espejo", "Espejo", "4"},
		{"Lámpara", "Lámpara", "1"},
		{"Linterna", "Linterna", "5"},
		{"Tienda", "Tienda", "5"},
		{"2 Botellas de Aceite", "2 Botellas de Aceite", "1"},
		{"Botella de Ácido", "Botella de líquido amarillento", "8"},
		{"Botella de Agua Bendita", "Botella de líquido transparente", "3"},
		{"Botella de Fuego Líquido", "Botella de liquido rojizo", "5"},
		{"Tinta", "Tinta", "1"},
		{"Tinta Roja", "Tinta Roja", "2"},
		{"Tinta Azul", "Tinta Azul", "1"},
		{"Capa de Calidad", "Capa de Calidad", "2"},
		{"Capa de Cuero", "Capa de Cuero", "1"},
		{"Capa de Cuero", "Capa de Cuero", "1"},
		{"Túnica de Calidad", "Túnica de Calidad", "2"},
		{"Botella de Vino Fino", "Botella de Vino", "1"},
		{"Poción de Curar I", "Poción Transparente", "6"},
		{"Poción de Curar I", "Poción Transparente", "6"},
		{"Poción de Curar I", "Poción Lechosa", "6"},
		{"Poción de Curar I", "Poción Lechosa", "6"},
		{"Poción de Curar I", "Poción Rojo Claro", "6"},
		{"Poción de Curar I", "Poción Rojo Claro", "6"},
		{"Poción de Armadura de Mago", "Poción Azúl", "8"},
		{"Poción de Armadura de Mago", "Poción Amarilla", "8"},
		{"Poción de Armadura de Mago", "Poción Púrpura", "8"},
		{"Poción de Protección", "Poción Verde", "8"}
	};
	
	static String[][] equipo_barato = {
		{"Cimitarra", "Cimitarra", "15"},
		{"Espada Corta", "Espada Corta", "10"},
		{"Espada Corta", "Espada Corta", "10"},
		{"Espada Larga", "Espada Larga", "15"},
		{"Espada Larga", "Espada Larga", "15"},
		{"Tridente", "Tridente", "15"},
		{"Alabarda", "Alabarda", "15"},
		{"Bardiche", "Bardiche", "10"},
		{"Bardiche", "Bardiche", "10"},
		{"Hocino Militar", "Hocino Militar", "12"},
		{"Martillo de Asta", "Martillo de Asta", "12"},
		{"Hacha Grande", "Hacha Grande", "12"},
		{"Hacha Grande", "Hacha Grande", "12"},
		{"Hacha de Batalla", "Hacha de Batalla", "15"},
		{"Martillo de Guerra", "Martillo de Guerra", "12"},
		{"Maza", "Maza", "12"},
		{"Maza", "Maza", "12"},
		{"Pico", "Pico", "10"},
		{"Daga F+1", "Daga de Calidad", "10"},
		{"Daga F+1", "Daga de Calidad", "10"},
		{"Puñal F+1", "Puñal de Calidad", "14"},
		{"Lanza F+1", "Lanza de Calidad", "14"},
		{"Lanza F+1", "Lanza de Calidad", "14"},
		{"Venablo F+1", "Venablo de Calidad", "10"},
		{"Voulge F+1", "Voulge de Calidad", "16"},
		{"Garrote de Guerra F+1", "Garrote de Guerra de Calidad", "10"},
		{"Hacha de Mano F+1", "Hacha de Mano de Calidad", "12"},
		{"Hoz F+1", "Hoz de Calidad", "12"},
		{"Rodela", "Rodela", "10"},
		{"Rodela", "Rodela", "10"},
		{"Escudo Ligero", "Escudo Ligero", "10"},
		{"Escudo Ligero", "Escudo Ligero", "10"},
		{"Yelmo de Metal", "Yelmo de Metal", "10"},
		{"Yelmo de Metal", "Yelmo de Metal", "10"},
		{"Candado F+1", "Candado de Calidad", "10"},
		{"Cuerda de Seda", "Cuerda de Seda", "10"},
		{"Grilletes", "Grilletes", "10"},
		{"Juego de Ganzúas", "Juego de Ganzúas", "10"},
		{"Silla de Monta", "Silla de Monta", "10"},
		{"2 Pociónes de Curar I", "2 Pociónes Blancas", "12"},
		{"2 Pociónes de Curar I", "2 Pociónes Rojas", "12"},
		{"2 Pociónes de Curar I", "2 Pociónes Rojo claro", "12"},
		{"2 Pociónes de Curar I", "2 Pociónes Celestes", "12"},
		{"2 Pociónes de Armadura de Mago", "2 Pociónes Anaranjadas", "16"},
		{"2 Pociónes de Armadura de Mago", "2 Pociónes Azules", "16"}
	};
	
	static String[][] equipo_moderado = {
		{"Arco Corto", "Arco Corto", "30"},
		{"Cimitarra F+1", "Cimitarra de Calidad", "30"},
		{"Espada Corta F+1", "Espada Corta de Calidad", "20"},
		{"Espada Corta F+1", "Espada Corta de Calidad", "20"},
		{"Espada Corta F+1", "Espada Corta de Calidad", "20"},
		{"Espada Corta F+1", "Espada Corta de Calidad", "20"},
		{"Tridente F+1", "Tridente de Calidad", "30"},
		{"Alabarda F+1", "Alabarda de Calidad", "30"},
		{"Alabarda F+1", "Alabarda de Calidad", "30"},
		{"Bardiche F+1", "Bardiche de Calidad", "20"},
		{"Bardiche F+1", "Bardiche de Calidad", "20"},
		{"Hocino Militar F+1", "Hocino Militar de Calidad", "24"},
		{"Martillo de Asta F+1", "Martillo de Asta de Calidad", "24"},
		{"Hacha Grande F+1", "Hacha Grande de Calidad", "24"},
		{"Hacha de Batalla F+1", "Hacha de Batalla de Calidad", "30"},
		{"Martillo de Guerra F+1", "Martillo de Guerra de Calidad", "24"},
		{"Maza F+1", "Maza de Calidad", "24"},
		{"Maza F+1", "Maza de Calidad", "24"},
		{"Pico F+1", "Pico de Calidad", "20"},
		{"Daga M+1", "Daga de Calidad", "20"},
		{"Daga M+1", "Daga de Calidad", "20"},
		{"Lanza M+1", "Lanza de Calidad", "28"},
		{"Lanza M+1", "Lanza de Calidad", "28"},
		{"Hacha de Mano M+1", "Hacha de Mano de Calidad", "24"},
		{"Hoz M+1", "Hoz de Calidad", "24"},
		{"Daga M+2", "Daga M+2", "30"},
		{"Daga M+2", "Daga M+2", "30"},
		{"Escudo Pesado", "Escudo Pesado", "20"},
		{"Escudo Pesado", "Escudo Pesado", "20"},
		{"Rodela F+1", "Rodela de Calidad", "20"},
		{"Rodela F+1", "Rodela de Calidad", "20"},
		{"Escudo Ligero F+1", "Escudo Ligero de Calidad", "20"},
		{"Escudo Ligero F+1", "Escudo Ligero de Calidad", "20"},
		{"Yelmo (Cuero) F+1", "Yelmo de Cuero de Calidad", "10"},
		{"Yelmo (Cuero) F+1", "Yelmo de Cuero de Calidad", "10"},
		{"Yelmo (Metal) F+1", "Yelmo Metalico de Calidad", "20"},
		{"Yelmo (Metal) F+1", "Yelmo Metalico de Calidad", "20"},
		{"Cuerda de Pelo de Gigante", "Cuerda de Pelo de Gigante", "20"},
		{"Juego de Ganzúas F+1", "Juego de Ganzúas de Calidad", "20"},
		{"Poción de Curar II", "Poción Transparente", "21"},
		{"Poción de Curar II", "Poción Transparente", "21"},
		{"Poción de Curar II", "Poción Lechosa", "21"},
		{"Poción de Curar II", "Poción Lechosa", "21"},
		{"Poción de Curar II", "Poción Blanca", "21"},
		{"Poción de Curar II", "Poción Blanca", "21"},
		{"Poción de Curar II", "Poción Gris", "21"},
		{"Poción de Curar II", "Poción Gris", "21"},
		{"Poción de Curar II", "Poción Rojo Oscuro", "21"},
		{"Poción de Curar II", "Poción Rojo Oscuro", "21"},
		{"Poción de Remover Paralisis", "Poción Celeste", "26"},
		{"Poción de Remover Paralisis", "Poción Verde", "26"},
		{"Poción de Remover Paralisis", "Poción Amarilla", "26"},
		{"Poción de Remover Paralisis", "Poción Azul Claro", "26"},
		{"Poción de Levitar", "Poción Púrpura", "26"},
		{"Poción de Levitar", "Poción Verde Claro", "26"},
		{"Poción de Fuerza de Toro ", "Poción Marrón", "26"},
		{"Poción de Resistencia de Oso", "Poción color Caramelo", "26"},
		{"Poción de Gracia Felina", "Poción Verde Oscuro", "26"},
		{"Poción de Astucia de Zorro", "Poción Anaranjada", "26"},
		{"Poción de Sabiduría de Búho", "Poción Violeta", "26"},
		{"Poción de Esplendor del Águila", "Poción Rosa", "26"},
		{"Capa de Ocultamiento", "Capa de Calidad", "30"},
		{"Botas Sigilosas", "Botas de Calidad", "30"}
	};
	
	static String[][] equipo_costoso = {
		{"Arco Largo", "Arco Largo", "60"},
		{"Arco Corto F+1", "Arco Corto de Calidad", "60"},
		{"Arco Largo F+1", "Arco Largo de Calidad", "120"},
		{"Cimitarra M+1", "Cimitarra de Calidad", "60"},
		{"Espada Corta M+1", "Espada Corta de Calidad", "40"},
		{"Espada Larga M+1", "Espada Larga de Calidad", "60"},
		{"Tridente M+1", "Tridente de Calidad", "60"},
		{"Alabarda M+1", "Alabarda de Calidad", "60"},
		{"Bardiche M+1", "Bardiche de Calidad", "40"},
		{"Martillo de Asta M+1", "Martillo de Asta de Calidad", "48"},
		{"Hacha Grande M+1", "Hacha Grande de Calidad", "48"},
		{"Hacha de Batalla M+1", "Hacha de Batalla de Calidad", "60"},
		{"Martillo de Guerra M+1", "Martillo de Guerra de Calidad", "48"},
		{"Maza M+1", "Maza de Calidad", "48"},
		{"Pico M+1", "Pico de Calidad", "40"},
		{"Arco Corto M+1", "Arco Corto de Calidad", "120"},
		{"Cimitarra M+2", "Cimitarra de Calidad", "90"},
		{"Espada Corta M+2", "Espada Corta de Calidad", "60"},
		{"Espada Larga M+2", "Espada Larga de Calidad", "90"},
		{"Lanza M+2", "Lanza de Calidad", "42"},
		{"Alabarda M+2", "Alabarda de Calidad", "90"},
		{"Martillo de Asta M+2", "Martillo de Asta de Calidad", "72"},
		{"Hacha Grande M+2", "Hacha Grande de Calidad", "72"},
		{"Hacha de Batalla M+2", "Hacha de Batalla de Calidad", "90"},
		{"Martillo de Guerra M+2", "Martillo de Guerra de Calidad", "72"},
		{"Maza M+2", "Maza de Calidad", "72"},
		{"Escudo Pesado F+1", "Escudo Pesado de Calidad", "40"},
		{"Poción de Curar III", "Poción Lechosa", "58"},
		{"Poción de Curar III", "Poción Lechosa", "58"},
		{"Poción de Curar III", "Poción Rojo Oscuro", "58"},
		{"Poción de Curar III", "Poción Rojo Oscuro", "58"},
		{"Poción de Curar III", "Poción Roja", "58"},
		{"Poción de Curar III", "Poción Roja", "58"},
		{"Poción de Curar III", "Poción Ambarina", "58"},
		{"Poción de Curar III", "Poción Ambarina", "58"},
		{"Poción de Álito de Fuego", "Poción Rojo Brillante", "72"},
		{"Poción de Álito de Fuego", "Poción Anaranjada Brillante", "72"},
		{"Poción de Volar", "Poción Celeste", "72"},
		{"Botas del Silencio", "Botas de Calidad", "80"},
		{"Capa de Camuflaje", "Capa de Calidad", "80"},
		{"Capa de Protección", "Capa de Calidad", "40"},
		{"Anillo de Protección", "Anillo Dorado", "50"},
		{"Cinturón de Fuerza", "Cinturón de Calidad", "50"},
		{"Brazaletes de Destreza", "Brazaletes de Calidad", "50"},
		{"Yelmo de Inteligencia", "Yelmo Ornamental", "50"}
	};
	
	
}
