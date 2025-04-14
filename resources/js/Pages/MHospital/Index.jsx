import React from 'react';
import CustomHeader from '@/Layouts/CustomHeader';
import { Link, useForm } from '@inertiajs/react';
import {
    ChakraProvider,
    defaultSystem,
    Text,
    Box,
    Table,
    Image,
    HStack,
    Button,
    Center,
    Input,
    Stack,
} from '@chakra-ui/react';
import {
    DialogBody,
    DialogCloseTrigger,
    DialogContent,
    DialogHeader,
    DialogRoot,
    DialogTitle,
    DialogTrigger,
} from "../../../../src/components/ui/dialog"
import { Field } from '../../../../src/components/ui/field';

const Index = ({ m_hospitals }) => {

    console.log(m_hospitals);

    // InertiaのuseFormを使用してフォーム関連の処理を実施
    // useFormのdelete関数が、JavaScriptの予約後となってしまうので、リネームをして別の変数名を割り当てるようにする。
    const { data, setData, get, delete: destroy } = useForm({
        hospital_name: ''
    });


    // 入力フォームで入力された際の処理
    const handleChange = (e) => {
        console.log('changeイベント発火');
        // Stateの更新変数に、フォームで入力されたinputタグのname属性をプロパティ名にして、valueにinputタグで入力された値をformData(state)にセットして値を更新する
        setData(e.target.name, e.target.value);

        console.log(data);
    }

    // 検索フォーム内の入力値が変更された場合

    // 検索ボタンクリック処理
    const handleSubmit = (e) => {
        console.log('検索処理');
        e.preventDefault();

        get(route('m_hospital.index'), { hospital_name: data.hospital_name });
    }

    // 削除イベント処理
    const handleDelete = (id, e) => {
        // 再レンダリング防止
        e.preventDefault();

        // destroy(route('m_hospital.destroy', id));
    }

    return (
        <ChakraProvider value={defaultSystem}>
            <>
                <CustomHeader />

                {/* メイン */}
                <Box className='main' width="90%" m="auto" bg='white' marginTop='20px' boxShadow='md' >
                    <HStack bg='gray.400' color='white'>
                        <Text textStyle={'2xl'} m='20px'>病院名マスタ一覧</Text>

                        {/* 検索フォーム */}
                        <DialogRoot>
                            <DialogTrigger asChild>
                                <Button variant="outline" size="xxl" bg="gray.800" p='0.5rem' w="10%">
                                    検索
                                </Button>
                            </DialogTrigger>
                                <DialogContent>
                                    <DialogHeader>
                                        <Center>
                                            <DialogTitle>病院名マスタ検索</DialogTitle>
                                        </Center>
                                    </DialogHeader>
                                    <DialogBody>
                                        <form onSubmit={handleSubmit}>
                                            <Stack gap="4">
                                                <Field label="病院名">
                                                    <Input
                                                        placeholder='病院名を入力してください'
                                                        type='text'
                                                        id='hospital_name'
                                                        name='hospital_name'
                                                        value={data.hospital_name}
                                                        onChange={handleChange}
                                                    />
                                                </Field>
                                            </Stack>
                                            <Center m="6">
                                                <Button type='submit' color='white' bg='orange.500' size='lg' p='5' width='30%' >検索</Button>
                                            </Center>
                                        </form>
                                    </DialogBody>
                                <DialogCloseTrigger />
                            </DialogContent>
                        </DialogRoot>

                        {/* リセットボタン */}
                        <Button as={Link} href={`/m_hospitals`} color='white' bg='gray.500' p='5'>リセット</Button>

                        {/* 登録フォーム */}
                        <Button as={Link} href={`/m_hospitals/create`} bg='orange.400' p="0.5rem">
                            病院名マスタ登録
                        </Button>

                    </HStack>

                    {/* テーブル */}
                    <Table.ScrollArea w="90%" m="auto" marginY="2rem" h="70vh" border="1px solid" borderColor="gray.200" p="1rem">
                        <Table.Root>
                            <Table.Header position="sticky" top="0" zIndex="1" bg='gray.400'>
                                <Table.Row>
                                    <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign='center' w='60%' fontSize={'md'}>病院名</Table.ColumnHeader>
                                    <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign='center' fontSize={'md'}>編集</Table.ColumnHeader>
                                    <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign='center' fontSize={'md'}>削除</Table.ColumnHeader>
                                </Table.Row>
                            </Table.Header>

                            <Table.Body>
                                {/* 三項演算子の条件文 病院マスタオブジェクトがtrueの場合 & m_hospitals（コレクション）をArray判定してtrueの場合 ＆ コレクション内にオブジェクトが存在している場合　*/}
                                {/* trueの場合 */}
                                {m_hospitals && Array.isArray(m_hospitals) && m_hospitals.length > 0 ? (
                                    m_hospitals.map((m_hospital, index) => (
                                        m_hospital && m_hospital.hospital_name ? ( // 病院オブジェクトが存在している & hospital_nameプロパティが存在しているかの判定条件
                                        // trueの場合
                                        <Table.Row key={index}>
                                            <Table.Cell textAlign='center' borderBottom="1px solid" borderColor="gray.300">
                                                {m_hospital.hospital_name}
                                            </Table.Cell>
                                            <Table.Cell borderBottom="1px solid" borderColor="gray.300">
                                                <Link variant='plain' href={`/m_hospitals/edit/${m_hospital.id}`}>
                                                    <Center>
                                                        <Image src="img/edit.png" />
                                                    </Center>
                                                </Link>
                                            </Table.Cell>
                                            <Table.Cell borderBottom="1px solid" borderColor="gray.300">
                                                <Center>
                                                    <Button onClick={(e) => handleDelete(m_hospital.id, e)}>
                                                        <Image src="img/delete.png" />
                                                    </Button>
                                                </Center>
                                            </Table.Cell>
                                        </Table.Row>
                                        ) : null //falseの場合は、nullを指定
                                    ))
                                ) : (
                                    // falseの場合、テーブルのRowに「データが未登録です」と表示
                                    <Table.Row>
                                        <Table.Cell colSpan={3} textAlign="center" borderBottom="1px solid" borderColor="gray.300">
                                            データが未登録です。
                                        </Table.Cell>
                                    </Table.Row>
                                )}
                            </Table.Body>
                        </Table.Root>
                    </Table.ScrollArea>

                </Box>
            </>
        </ChakraProvider>
    );
}

export default Index;
